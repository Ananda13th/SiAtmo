<?php
namespace SiAtmo\Http\Controllers\ApiControllers;
use Illuminate\Http\Request;
use DB;
use PDF;
use DateTime;
use SiAtmo\TransaksiPenjualan;
use SiAtmo\DetilTransaksiSparepart;
use SiAtmo\DetilTransaksiService;
use Carbon\Carbon;
use SiAtmo\Sparepart;
use SiAtmo\Cabang;

class ReportController extends Controller
{
    public function LaporanPendapatanBulanan(Request $request)
    {
        if($request->tahun == "")
        {
            return view('laporan/pendapatanBulananMobile');
        }
        else{
            $query = DB::select(
                "SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan, COALESCE(SUM(d.hargaJualTransaksi*d.jumlahSparepart),0) as Sparepart, COALESCE(SUM(e.biayaServiceTransaksi),0) as Service, COALESCE( COALESCE(SUM(d.hargaJualTransaksi*d.jumlahSparepart),0)+COALESCE(SUM(e.biayaServiceTransaksi),0),0) as Total FROM (
                    SELECT '01' AS bulan
                    UNION SELECT '02' AS bulan
                    UNION SELECT '03' AS bulan
                    UNION SELECT '04' AS bulan
                    UNION SELECT '05' AS bulan
                    UNION SELECT '06' AS bulan
                    UNION SELECT '07' AS bulan
                    UNION SELECT '08' AS bulan
                    UNION SELECT '09' AS bulan
                    UNION SELECT '10' AS bulan
                    UNION SELECT '11' AS bulan
                    UNION SELECT '12' AS bulan
                ) AS m LEFT JOIN transaksipenjualan p ON MONTHNAME(p.tanggalTransaksi) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
                LEFT JOIN detiltransaksisparepart d ON p.kodeNota=d.kodeNota
                LEFT JOIN detiltransaksiservice e ON p.kodeNota=e.kodeNota
                where YEAR(p.tanggalTransaksi)=$request->tahun or YEAR(P.tanggalTransaksi) is null
                GROUP BY m.bulan, YEAR(p.tanggalTransaksi)"
            );
            $count=count($query);
            $label              = [];
            $totalPendapatan    = [];
            $bulan              = [];
            $spareparts         = [];
            $service            = [];
            $total              = 0;

            for($i=0;$i<$count;$i++)
            {
                $bulan[$i]             = $query[$i]->Bulan;
                $sparepart[$i]         = $query[$i]->Sparepart;
                $service[$i]           = $query[$i]->Service;
                $totalPendapatan[$i]   = $query[$i]->Total;
                $total                 = $total+$query[$i]->Sparepart+$query[$i]->Service;
            }

            return view('printPreview/pendapatanBulananMobile',  ['tahun'=>$request->tahun, 'bulan'=>$bulan, 'sparepart'=>$sparepart, 'service'=>$service, 'data'=>$query, 'total'=>$totalPendapatan]);
        }
    }

    public function LaporanSisaStok(Request $request) {

        if($request->tipe == "")
        {
            $spareparts = Sparepart::all();
            return view('laporan/sisaStokMobile')->with(['spareparts' => $spareparts]);
        }
        else {
            $tipe = $request->tipe;
            $tahun = $request->tahun;

            $query = DB::select(
                "SELECT
                m.MONTH as 'Bulan',
                COALESCE(s.SISA, 0) as 'SisaStok'
                FROM ( 
                    SELECT 'January' AS MONTH 
                    UNION SELECT 'February' AS MONTH 
                    UNION SELECT 'March' AS MONTH 
                    UNION SELECT 'April' AS MONTH 
                    UNION SELECT 'May' AS MONTH 
                    UNION SELECT 'June' AS MONTH 
                    UNION SELECT 'July' AS MONTH 
                    UNION SELECT 'August' AS MONTH 
                    UNION SELECT 'September' AS MONTH 
                    UNION SELECT 'October' AS MONTH 
                    UNION SELECT 'November' AS MONTH 
                    UNION SELECT 'December' AS MONTH ) 
                    AS m 
                    
                    LEFT JOIN
                    (
                        SELECT MONTHNAME(tanggal) as 'Tgl', 
                        (SUM(IF(jumlah>0, jumlah, 0)) - SUM(IF(jumlah<0, jumlah, 0))
                        + SUM(sparepart.jumlahStok)) AS 'SISA'
                        FROM historisparepart
                        INNER JOIN sparepart ON historisparepart.kodeSparepart = sparepart.kodeSparepart
                        WHERE YEAR(tanggal) = '$tahun' AND sparepart.tipeSparepart = '$tipe'
                        GROUP BY MONTHNAME(tanggal)
                    ) as s ON s.Tgl = M.MONTH
                GROUP BY m.MONTH
                ORDER BY STR_TO_DATE(m.MONTH, '%M')"
            );

            return view('printPreview/sisaStokMobile', ['tahun'=>$tahun, 'tipe'=>$tipe,'data'=>$query]);
        }
    }

    public function LaporanSparepartTerlaris(Request $request)
    {
        $result = DB::select(
            "SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan, Coalesce((SELECT s.namaSparepart 
            FROM detiltransaksisparepart t 
            inner join sparepart s on t.kodeSparepart = s.kodeSparepart inner join transaksipenjualan a on t.kodeNota = a.kodeNota
            where YEAR (a.tanggalTransaksi) = $request->tahun            
            and MONTHNAME(a.tanggalTransaksi) = MONTHNAME(STR_TO_DATE((m.bulan), '%m'))
            group by t.kodeSparepart 
            order by sum(t.jumlahSparepart) 
            DESC LIMIT 1),'-') AS NamaBarang, Coalesce(
                (select s.tipeSparepart from detiltransaksisparepart t 
                inner join sparepart s on t.kodeSparepart = s.kodeSparepart 
                inner join transaksipenjualan a on t.kodeNota = a.kodeNota 
                where YEAR (a.tanggalTransaksi) = $request->tahun                            
                and MONTHNAME(a.tanggalTransaksi) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
                group by t.kodeSparepart 
                order by sum(t.jumlahSparepart) DESC LIMIT 1),'-') AS TipeBarang, 
                Coalesce(
                    (select sum(jumlahSparepart) from detiltransaksisparepart t 
                    inner join transaksipenjualan a on t.kodeNota = a.kodeNota 
                    where YEAR (a.tanggalTransaksi) = $request->tahun                                                
                    and MONTHNAME(a.tanggalTransaksi) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
                    group by kodeSparepart order by sum(jumlahSparepart) 
                    DESC LIMIT 1),'-') AS JumlahPenjualan
            FROM(
            SELECT '01' AS bulan
                UNION SELECT '02' AS bulan
                UNION SELECT '03' AS bulan
                UNION SELECT '04' AS bulan
                UNION SELECT '05' AS bulan
                UNION SELECT '06' AS bulan
                UNION SELECT '07' AS bulan
                UNION SELECT '08' AS bulan
                UNION SELECT '09' AS bulan
                UNION SELECT '10' AS bulan
                UNION SELECT '11' AS bulan
                UNION SELECT '12' AS bulan
            ) AS m");
        return view('printPreview/sparepartTerlarisMobile', ['tahun'=>$request->tahun, 'data'=>$result]);
    }

    public function LaporanServiceTerlaris(Request $request)
    {

        $result = DB::select(
            "SELECT
            p.merkKendaraan AS Merk,
            p.tipeKendaraan AS Tipe,
            s.keterangan AS `NamaService`,
            Count( t.tanggalTransaksi ) AS `JumlahService`,
            YEAR(t.tanggalTransaksi) AS Tahun ,
            MONTHNAME(t.tanggalTransaksi) AS Bulan
        FROM
            kendaraan AS p
            INNER JOIN kendaraankonsumen AS q ON q.merkKendaraan = p.kodeKendaraan
            INNER JOIN detiltransaksiservice AS r ON r.platNomorKendaraan = q.platNomorKendaraan
            INNER JOIN transaksipenjualan AS t ON r.kodeNota = t.kodeNota
            INNER JOIN service AS s ON s.kodeService = r.kodeService
        WHERE
            MONTHNAME( t.tanggalTransaksi ) = $request->bulan
            AND YEAR ( t.tanggalTransaksi ) = $request->tahun
            AND t.kodeNota LIKE '%SV%'
            OR t.kodeNota LIKE '%SS%'
        GROUP BY
            p.merkKendaraan,
            p.tipeKendaraan,
            s.keterangan");
  

        return view('printPreview/serviceTerlarisMobile', ['tahun'=>$request->tahun, 'bulan'=>$request->bulan, 'data'=>$result]);
    }

    public function LaporanPengeluaranBulanan(Request $request)
    {
        $query = DB::select(
            "SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan, COALESCE((SUM(p.totalPengeluaran)),0) as Total FROM (
                SELECT '01' AS bulan
                UNION SELECT '02' AS bulan
                UNION SELECT '03' AS bulan
                UNION SELECT '04' AS bulan
                UNION SELECT '05' AS bulan
                UNION SELECT '06' AS bulan
                UNION SELECT '07' AS bulan
                UNION SELECT '08' AS bulan
                UNION SELECT '09' AS bulan
                UNION SELECT '10' AS bulan
                UNION SELECT '11' AS bulan
                UNION SELECT '12' AS bulan
            ) AS m LEFT JOIN pemesanan p ON MONTHNAME(p.tanggalPemesanan) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
            where YEAR(p.tanggalPemesanan)='$request->tahun' or YEAR(P.tanggalPemesanan) is null
            GROUP BY m.bulan, YEAR(p.tanggalPemesanan)"
        );
        $count=count($query);
        $label  = [];
        $data   = [];

        for($i=0;$i<$count;$i++)
        {
            $label[$i]  = $query[$i]->Bulan;
            $data[$i]   = $query[$i]->Total;
        }
        return view('printPreview/pengeluaranBulananMobile',  ['tahun'=>$request->tahun, 'data'=>$query, 'bulan'=>$label, 'pengeluaran'=>$data]);
    }

    public function LaporanCabang(Request $request)
    {
    
        $query = DB::select(
            "SELECT c.namaCabang AS Cabang, SUM(t.total) AS Total 
                FROM transaksipenjualan AS t 
                INNER JOIN pegawaionduty AS p ON p.kodeNota = t.kodeNota
                INNER JOIN users AS u ON u.email = p.emailPegawai
                INNER JOIN cabang AS c ON c.idCabang = u.idCabang
                WHERE YEAR(t.tanggalTransaksi) = $request->tahun
                GROUP BY c.namaCabang"
        );

        $count=count($query);
        $label  = [];
        $data   = [];
        $cabang = [];

        for($i=0;$i<$count;$i++)
        {
            $label[$i]  = $query[$i]->Cabang;
            $data[$i]   = $query[$i]->Total;
        }

        return view('printPreview/pendapatanCabangMobile',  ['tahun'=>$request->tahun, 'data'=>$query, 'cabang'=>$label, 'pendapatan'=>$data]);  
    }
}