<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiPenjualan;
use App\DetilTransaksiService;
use App\Service;
use App\Posisi;
use App\User;
use App\KendaraanKonsumen;
use Illuminate\Support\Facades\Auth;
use App\PegawaiOnDuty;
use App\Sparepart;
use Carbon\Carbon;

class TransaksiServiceController extends Controller
{
    public function index()
    {
        $transaksiService   = TransaksiPenjualan::leftJoin('detiltransaksiservice','transaksipenjualan.kodenota','=','detiltransaksiservice.kodenota')
            ->leftJoin('kendaraankonsumen','kendaraankonsumen.platNomorKendaraan','=','detiltransaksiservice.platNomorKendaraan')
            ->leftJoin('service','service.kodeService','=','detiltransaksiservice.kodeService')->where('transaksipenjualan.kodeNota', 'like', '%'.'SV'.'%')
            ->get();
        return view('transaksiService/index', ['tService'=>$transaksiService, 'no'=>0]);

    }

    public function create()
    {
        $service    = Service::all();
        $sparepart  = Sparepart::all();
        $konsumen   = KendaraanKonsumen::all();
        $pegawai    = User::all();
        return view('transaksiService/create', ['service'=>$service, 'konsumen'=>$konsumen, 'pegawai'=>$pegawai, 'sparepart'=>$sparepart]);
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
            'email'=> $user->email,
            'kodeNota'=>$transaksi->kodeNota
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
