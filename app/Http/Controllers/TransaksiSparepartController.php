<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\TransaksiPenjualan;
use SiAtmo\DetilTransaksiSparepart;
use SiAtmo\Sparepart;
use SiAtmo\PegawaiOnDuty;
use SiAtmo\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiSparepartController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user();
        $transaksiSparepart   = TransaksiPenjualan::leftJoin('detiltransaksisparepart','transaksipenjualan.kodenota','=','detiltransaksisparepart.kodenota')
            ->leftJoin('sparepart','sparepart.kodeSparepart','=','detiltransaksisparepart.kodeSparepart')
            ->where('transaksipenjualan.kodeNota', 'like', '%'.'SP'.'%')
            ->get();
        return view('transaksiSparepart/index', ['tSparepart'=>$transaksiSparepart, 'no'=>0, 'pegawai'=>$pegawai, 'noDetil'=>0]);
    }

    public function create()
    {
        $sparepart    = Sparepart::all();
        return view('transaksiSparepart/create', ['sparepart'=>$sparepart]);
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
        
        $countSubtotal = count($request->hargaJualTransaksi);
        $subtotal=0;
        for($i = 0; $i<$countSubtotal; $i++)
        {
            $subtotal += $request->hargaJualTransaksi[$i]*$request->jumlahSparepart[$i];
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
        
        // $user = Auth::user();
        // $pegawaiOnDuty = PegawaiOnDuty::create([
        //      'email'=> $user->email,
        //      'kodeNota'=>$transaksi->kodeNota
        // ]);

        $count = count($request->kodeSparepart);
        for($i = 0; $i<$count; $i++)
        {
            Sparepart::where('kodeSparepart', '=', $request->kodeSparepart[$i])->decrement('jumlahStok', $request->jumlahSparepart[$i]);
            $detiltransaksi = DetilTransaksiSparepart::create([
                'kodeNota'=>$transaksi->kodeNota,
                'hargaJualTransaksi'=>$request->hargaJualTransaksi[$i], 
                'jumlahSparepart'=>$request->jumlahSparepart[$i], 
                'kodeSparepart'=>$request->kodeSparepart[$i]
            ]);

            
        }
        return redirect()->route('transaksiSparepart.index')->with('success', 'Data berhasil ditambah');
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
