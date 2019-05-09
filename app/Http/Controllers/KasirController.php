<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\TransaksiPenjualan;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function index()
    {
        $transaksiService   = TransaksiPenjualan::where('transaksipenjualan.kodeNota', 'like', '%'.'SV'.'%')
        ->get();
        $transaksiSparepart = TransaksiPenjualan::where('transaksipenjualan.kodeNota', 'like', '%'.'SP'.'%')
        ->get();
        $transaksiFull = TransaksiPenjualan::where('transaksipenjualan.kodeNota', 'like', '%'.'SS'.'%')
        ->get();
        return view('dataTransaksi/index', ['transaksiService'=>$transaksiService, 'transaksiSparepart'=>$transaksiSparepart, 'transaksiFull'=>$transaksiFull,'no'=>0, ]);
    }

    public function create()
    {
      
    }

    public function store(Request $request)
    {

    }

    public function edit($kodeNota)
    {
        $transaksi = TransaksiPenjualan::find($kodeNota);

        return view('dataTransaksi/finalisasi', ['dataNota'=>$transaksi]);
    }

    public function show($kodeNota)
    {

    }

    public function update(Request $request, $kodeNota)
    {
        $transaksi = TransaksiPenjualan::find($kodeNota);
        $transaksi->diskon = $request['diskon'];
        $transaksi->tanggalLunas = Carbon::now();
        $transaksi->statusTransaksi = 'Selesai';
        $transaksi->update();
        TransaksiPenjualan::where('kodeNota', $request->kodeNota)->decrement('total', $request->diskon);
       
        return redirect()->route('dataTransaksi.index')->with('success', 'Total bayar : {{$transaksi->total}}');
    }

    public function destroy($kodeNota)
    {

    }

    public function lihatSuratLunasService(Request $request, $kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        $user = Auth::user();
        $pdf = PDF::loadView('pdf.notaLunasService', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
        return $pdf->stream();
    }

    public function lihatSuratLunasSparepart(Request $request, $kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiSparepart::leftJoin('service', 'detiltransaksisparepart.kodeSparepart', '=', 'sparepart.kodeSparepart')
        ->get();
        $user = Auth::user();
        $pdf = PDF::loadView('pdf.notaLunasSparepart', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
        return $pdf->stream();
    }
}
