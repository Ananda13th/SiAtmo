<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\TransaksiPenjualan;
use SiAtmo\DetilTransaksiService;
use SiAtmo\Service;
use SiAtmo\Posisi;
use SiAtmo\User;
use SiAtmo\KendaraanKonsumen;
use Illuminate\Support\Facades\Auth;
use SiAtmo\PegawaiOnDuty;
use SiAtmo\Sparepart;
use Carbon\Carbon;
use PDF;

class TransaksiServiceController extends Controller
{
    public function index()
    {
        $transaksiService   = TransaksiPenjualan::where('transaksipenjualan.kodeNota', 'like', '%'.'SV'.'%')
        ->get();
        return view('transaksiService/index', ['tService'=>$transaksiService, 'no'=>0]);

    }

    public function create()
    {
        $service    = Service::all();
        $sparepart  = Sparepart::all();
        $konsumen   = KendaraanKonsumen::all();
        $pegawai    = User::all();
        $kode       = TransaksiPenjualan::where('transaksipenjualan.kodeNota', 'like', '%'.'SV'.'%', 'AND', 'tanggalTransaksi', '='.Carbon::now())
        ->orderBy('tanggaltransaksi', 'desc')
        ->first();
        return view('transaksiService/create', ['service'=>$service, 'konsumen'=>$konsumen, 'pegawai'=>$pegawai, 'sparepart'=>$sparepart, 'kode'=>$kode]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kodeNota'=>'required|max:13',
            'namaKonsumen'=>'required', 
            'noTelpKonsumen'=>'required', 
            'alamatKonsumen'=>'required',
            'biayaServiceTransaksi'=>'required', 
            'platNomorKendaraan'=>'required', 
            'kodeService'=>'required'
        ]);
        
        $countSubtotal = count($request->biayaServiceTransaksi);
        $subtotal=0;
        for($i = 0; $i<$countSubtotal; $i++)
        {
            $subtotal += $request->biayaServiceTransaksi[$i];
        }

        $transaksi = TransaksiPenjualan::create([
            'kodeNota'=>$request->kodeNota,
            'tanggalTransaksi'=>Carbon::now(), 
            'statusTransaksi'=>'sedang dikerjakan',
            'subtotal'=>$subtotal, 
            'total'=>$subtotal,
            'namaKonsumen'=>$request->namaKonsumen, 
            'noTelpKonsumen'=>$request->noTelpKonsumen, 
            'alamatKonsumen'=>$request->alamatKonsumen,
        ]);

        $user = Auth::user();
        $pegawaiOnDuty = PegawaiOnDuty::create([
            'emailPegawai'=> $user['email'],
            'kodeNota'=>$transaksi['kodeNota']
        ]);

        $count = count($request->kodeService);
        for($i = 0; $i<$count; $i++)
        {
            $detiltransaksi = DetilTransaksiService::create([
                'kodeNota'=>$transaksi->kodeNota,
                'biayaServiceTransaksi'=>$request->biayaServiceTransaksi[$i], 
                'platNomorKendaraan'=>$request->platNomorKendaraan[$i], 
                'emailPegawai'=>$request->emailPegawai[$i], 
                'kodeService'=>$request->kodeService[$i]
            ]);
        }
        return redirect()->route('transaksiService.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit($kodeNota)
    {
        $dataNota = TransaksiService::find($kodeNota);

        return view('transaksiService.edit', ['dataNota'=>$dataNota]);

    }

    public function downloadPDF($kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        $user = Auth::user();
        $pdf = PDF::loadView('pdf.SPKService', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
        return $pdf->stream();
  
      }

    public function show($kodeNota)
    {

    }

    public function update(Request $request, $kodeNota)
    {
        
    }

    public function destroy($kodeNota)
    {

    }

}
