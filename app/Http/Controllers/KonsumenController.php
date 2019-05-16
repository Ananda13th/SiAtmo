<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\TransaksiPenjualan;
use SiAtmo\Sparepart;

class KonsumenController extends Controller
{
    public function riwayat() {

        $transaksi = TransaksiPenjualan::leftJoin('detiltransaksiservice', 'detiltransaksiservice.kodeNota', '=', 'transaksiPenjualan.kodeNota')
        ->leftJoin('detiltransaksisparepart', 'detiltransaksisparepart.kodeNota', '=', 'transaksiPenjualan.kodeNota')->get();
        return view('konsumen.riwayat', ['transaksi'=>$transaksi]);

    }

    public function katalog() {
        
        $sparepart = Sparepart::all();

        return view('konsumen.katalog', ['sparepart'=>$sparepart]);

    }
}
