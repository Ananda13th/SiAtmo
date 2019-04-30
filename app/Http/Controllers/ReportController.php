<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use DateTime;

class ReportController extends Controller
{
    public function LaporanPendapatanBulanan()
    {
        $transaksi = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi) AS Bulan, SUM(total) as Pendapatan'))
        //->where('tanggaltransaksi', 'LIKE'.$request->tahun)
        ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi)'))
        ->get();
        // $dateObj   = DateTime::createFromFormat('!m', $transaksi['Bulan']);
        // $monthName = $dateObj->format('F'); // March
        // $transaksi['Bulan'] = $montName;
        //dd($transaksi);
  
        $pdf = PDF::loadView('pdf.pendapatanBulanan', ['data'=>$transaksi]);
        return $pdf->stream();
    }

    public function ApiLaporanBulanan()
    {
        $transaksi = DB::table("transaksipenjualan")->select(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi) AS Bulan, SUM(total) as Pendapatan'))
        ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggaltransaksi)'))
        ->get();
        return response()->json($transaksi);
    }
}
