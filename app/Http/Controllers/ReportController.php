<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use DateTime;
use SiAtmo\TransaksiPenjualan;
use Carbon\Carbon;
use SiAtmo\Sparepart;

class ReportController extends Controller
{
    public function LaporanPendapatanBulanan()
    {
        $query = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi) AS Bulan, SUM(total) as Pendapatan'))
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
        $pdf = PDF::loadView('pdf.pendapatanBulanan', ['data'=>$query, 'bulan'=>$label, 'pendapatan'=>$data]);
        return $pdf->stream();
    }


    public function LaporanSisaStok(Request $request) {

        if($request->kode == "")
        {
            $sparepart = Sparepart::all();
            return view('laporan/sisaStok')->with(['sparepart' => $sparepart]);
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
}
