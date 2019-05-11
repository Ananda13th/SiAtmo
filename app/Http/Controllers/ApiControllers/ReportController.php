<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

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
  
        return response()->json($transaksi);
    }
}
