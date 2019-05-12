<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use DateTime;
use SiAtmo\TransaksiPenjualan;
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

    public function LaporanStokTerlaris()
    {
        $query = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi) AS Bulan, detiltransaksisparepart.jumlahStok, sparepart.namaSparepart, sparepart.tipeSparepart'))
        ->leftJoin('detiltransaksisparepart', 'transaksipenjualan.kodeNota', '=', 'detiltransaksisparepart.kodesparepart')
        ->leftJoin('spareapart', 'sparepart.kodeSparepart', '=', 'detiltransaksisparepart.kodeSparepart')
        ->get();

        dd($query);
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
            $label  = [];
            $data   = [];

            for($i=0;$i<$count;$i++)
            {
                $label[$i]  = $query[$i]->Bulan;
                $data[$i]   = $query[$i]->Pengeluaran;
            }

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
