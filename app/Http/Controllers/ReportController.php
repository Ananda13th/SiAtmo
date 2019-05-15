<?php

namespace SiAtmo\Http\Controllers;

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
            return view('laporan/laporanBulanan');
        }
        else{
            $query = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi) AS Bulan, SUM(total) as Pendapatan'))
            ->where('tanggalTransaksi', 'LIKE', '%'.$request->tahun.'%')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi)'))
            ->get();
            
            $count=count($query);
            $label  = [];
            $data   = [];

            for($i=0;$i<$count;$i++)
            {
                $label[$i]  = $query[$i]->Bulan;
                $data[$i]   = $query[$i]->Pendapatan;
            }

            return view('printPreview/pendapatanBulanan',  ['data'=>$query, 'bulan'=>$label, 'pendapatan'=>$data]);
            // $pdf = PDF::loadView('pdf.pendapatanBulanan', ['data'=>$query, 'bulan'=>$label, 'pendapatan'=>$data]);
            // return $pdf->stream();
        }
    }


    public function LaporanSisaStok(Request $request) {

        if($request->kode == "")
        {
            $spareparts = Sparepart::all();
            return view('laporan/sisaStok')->with(['spareparts' => $spareparts]);
        }
        else {
            $query = DB::table("historisparepart")->select(DB::raw('EXTRACT(MONTH FROM tanggal) AS Bulan, SUM(jumlah) as Sisa'))
            ->where('kodeSparepart', $request->kode)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggal)'))
            ->get();
            return view('printPreview/sisaStok', ['data'=>$query]);
        }
    }

    public function LaporanSparepartTerlaris()
    {
        // $result = DB::table("detiltransaksisparepart")
        // ->leftJoin('sparepart', 'sparepart.kodeSparepart', 'detiltransaksisparepart.kodeSparepart')
        // ->leftJoin('transaksipenjualan', 'transaksipenjualan.kodeNota', 'detiltransaksisparepart.kodeNota')
        // ->select('sparepart.namaSparepart', DB::raw('COUNT(*) as total'))
        // ->groupBy(DB::raw('EXTRACT(MONTH FROM transaksipenjualan.tanggalTransaksi)'), 'sparepart.namaSparepart')
        // ->havingRaw("COUNT(*) > 0")
        // ->get();

        $result = DB::select('SELECT sparepart.namaSparepart, COUNT(*) AS total, MONTHNAME(transaksipenjualan.tanggalTransaksi) AS Bulan
        FROM sparepart JOIN detiltransaksisparepart ON sparepart.kodeSparepart = detiltransaksisparepart.kodeSparepart JOIN
        transaksipenjualan ON transaksipenjualan.kodeNota = detiltransaksisparepart.kodeNota GROUP BY MONTHNAME(transaksipenjualan.tanggalTransaksi), sparepart.namaSparepart');
        $count      = count($result);
        $store      = $result[0]->total;
        $tampung    = $result[0]->Bulan;
        $bulan      = [];
        $jumlah     = [];
        $keterangan = [];
        for($i=1;$i<$count;$i++)
        {
            if($result[$i]->Bulan != $result[$i-1]->Bulan)
            {
                $bulan[$i]          = $result[$i]->Bulan;
                $tampung            = $result[$i]->Bulan;
                if($result[$i]->total > $store)
                {
                    $store          = $result[$i]->total;
                    $jumlah[$i]     = $result[$i]->total;
                    $keterangan[$i] = $result[$i]->namaSparepart;
                }
            }
            else 
            {
                $bulan[$i]      = $tampung;
                if($result[$i]->total > $store)
                {
                    $store          = $result[$i]->total;
                    $jumlah[$i]     = $result[$i]->total;
                    $keterangan[$i] = $result[$i]->namaSparepart;
                }
            }
            
        }
        dd($result);
        return view('printPreview/sparepartTerlaris', ['jumlah'=>$jumlah, 'keterangan'=>$keterangan]);
    }

    public function LaporanServiceTerlaris()
    {
        $result = DB::table("detiltransaksiservice")
        ->leftJoin('service', 'service.kodeService', 'detiltransaksiservice.kodeService')
        ->leftJoin('transaksipenjualan', 'transaksipenjualan.kodeNota', 'detiltransaksiservice.kodeNota')
        ->select(DB::raw('EXTRACT(MONTH FROM transaksipenjualan.tanggalTransaksi) as Bulan'), 'service.keterangan', DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('EXTRACT(MONTH FROM transaksipenjualan.tanggalTransaksi)'), 'service.keterangan')
        ->havingRaw("COUNT(*) > 0")
        ->get();

        dd($result);
        $count      = count($result);
        $store      = 0;
        for($i=0;$i<$count;$i++)
        {
            if($result[$i]->total > $store)
            {
                $store      = $result[$i]->total;
                $jumlah     = $result[$i]->total;
                $keterangan = $result[$i]->keterangan;
            }
            
        }
        return view('printPreview/serviceTerlaris', ['jumlah'=>$jumlah, 'keterangan'=>$keterangan]);
    }

    public function LaporanPengeluaranBulanan(Request $request)
    {
        if($request->tahun == "")
        {
            return view('laporan/pengeluaranBulanan');
        }
        else{
            $query = DB::table("pemesanan")->select(DB::raw('EXTRACT(MONTH FROM tanggalPemesanan) AS Bulan, SUM(totalPengeluaran) as Pengeluaran'))
            ->where('tanggalPemesanan', 'LIKE', '%'.$request->tahun.'%')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggalPemesanan)'))
            ->get();
            
            $count=count($query);
            //dd($count);
            $label  = [];
            $data   = [];

            for($i=0;$i<$count;$i++)
            {
                $label[$i]  = $query[$i]->Bulan;
                $data[$i]   = $query[$i]->Pengeluaran;
            }

            return json_encode(array('label'=>$label, 'data'=>$data));
            return view('printPreview/pengeluaranBulanan',  ['data'=>$query, 'bulan'=>$label, 'pengeluaran'=>$data]);
        }
    }

    public function LaporanCabang(Request $request)
    {
        if($request->cabang == "")
        {
            $cabang = Cabang::all();
            return view('laporan/pendapatanCabang', ['cabang'=>$cabang]);
        }
        else{
            $query = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggalTransaksi) AS Bulan, SUM(total) as Pendapatan'))
            ->leftJoin('pegawaionduty', 'pegawaionduty.kodeNota', 'transaksipenjualan.kodeNota')
            ->leftJoin('users', 'pegawaionduty.emailPegawai', 'users.email')
            ->leftJoin('cabang', 'users.idCabang', 'cabang.idCabang')
            ->where('users.idCabang', 'LIKE', '%'.$request->cabang.'%')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM transaksiPenjualan.tanggalTransaksi)'))
            ->get();

            $count=count($query);
            $label  = [];
            $data   = [];
            $cabang = [];

            for($i=0;$i<$count;$i++)
            {
                $label[$i]  = $query[$i]->Bulan;
                $data[$i]   = $query[$i]->Pendapatan;
            }

            return view('printPreview/pendapatanCabang',  ['data'=>$query, 'bulan'=>$label, 'pendapatan'=>$data]);
        }
    }
}
