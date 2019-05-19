<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\TransaksiPenjualan;
use SiAtmo\DetilTransaksiSparepart;
use SiAtmo\Sparepart;
use SiAtmo\User;
use SiAtmo\DetilTransaksiService;
use SiAtmo\Service;
use SiAtmo\Posisi;
use SiAtmo\KendaraanKonsumen;
use Illuminate\Support\Facades\Auth;
use SiAtmo\PegawaiOnDuty;
use Carbon\Carbon;

class TransaksiFullController extends Controller
{
    public function index()
    {
        $transaksiFull = TransaksiPenjualan::where('kodeNota', 'LIKE', '%SS%')->get();
        return view('transaksiFull/index', ['tFull'=>$transaksiFull, 'no'=>0, ]);
    }

    public function create()
    {
        $sparepart  = Sparepart::all();
        $service    = Service::all();
        $konsumen   = KendaraanKonsumen::all();
        $pegawai    = User::all();
        return view('transaksiFull/create', ['service'=>$service, 'konsumen'=>$konsumen, 'pegawai'=>$pegawai,'sparepart'=>$sparepart]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kodeNota'=>'required|max:13',
            'namaKonsumen'=>'required', 
            'noTelpKonsumen'=>'required', 
            'alamatKonsumen'=>'required',
            'hargaJualTransaksi'=>'required', 
            'kodeSparepart'=>'required'
        ]);
        

        $countSubtotalSparepart = count($request->kodeSparepart);
        $countSubtotalService = count($request->kodeService);
        $subtotalSparepart=0;
        $subtotalService=0;

        for($i = 0; $i<$countSubtotalSparepart; $i++)
        {
            $subtotalSparepart += $request->hargaJualTransaksi[$i]*$request->hargaJualTransaksi[$i];
        }

        for($i = 0; $i<$countSubtotalService; $i++)
        {
            $subtotalService += $request->biayaServiceTransaksi[$i];
        }

        $subtotal= $subtotalService+$subtotalSparepart;
        $total=$subtotal;

        $transaksi = TransaksiPenjualan::create([
            'kodeNota'=>$request->kodeNota,
            'tanggalTransaksi'=>Carbon::now(), 
            'statusTransaksi'=>'sedang dikerjakan',
            'subtotal'=>$subtotal, 
            'total'=>$total,
            'namaKonsumen'=>$request->namaKonsumen, 
            'noTelpKonsumen'=>$request->noTelpKonsumen, 
            'alamatKonsumen'=>$request->alamatKonsumen,
        ]);

        $user = Auth::user();
        $pegawaiOnDuty = PegawaiOnDuty::create([
            'email'=> $user->email,
            'kodeNota'=>$request->kodeNota
        ]);

        for($i = 0; $i<$countSubtotalSparepart; $i++)
        {
            $detiltransaksi = DetilTransaksiSparepart::create([
                'kodeNota'=>$transaksi->kodeNota,
                'hargaJualTransaksi'=>$request->hargaJualTransaksi[$i], 
                'jumlahSparepart'=>$request->jumlahSparepart[$i], 
                'kodeSparepart'=>$request->kodeSparepart[$i]
            ]);
        }
        for($i = 0; $i<$countSubtotalService; $i++)
        {
            $detiltransaksi = DetilTransaksiService::create([
                'kodeNota'=>$transaksi->kodeNota,
                'biayaServiceTransaksi'=>$request->biayaServiceTransaksi[$i], 
                'platNomorKendaraan'=>$request->platNomorKendaraan[$i], 
                'emailPegawai'=>$request->emailPegawai[$i], 
                'kodeService'=>$request->kodeService[$i]
            ]);
        }

        return redirect()->route('transaksiFull.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit($kodeNota)
    {
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
