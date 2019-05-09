<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use DateTime;
use SiAtmo\TransaksiPenjualan;
use Carbon\Carbon;

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
        return $pdf->download();
    }
}
