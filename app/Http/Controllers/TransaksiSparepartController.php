<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiPenjualan;
use App\DetilTransaksiSparepart;
use App\Sparepart;
use App\PegawaiOnDuty;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiSparepartController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user();
        $sparepart=DetilTransaksiSparepart::all();
        $transaksiSparepart   = TransaksiPenjualan::leftJoin('detiltransaksisparepart','transaksipenjualan.kodenota','=','detiltransaksisparepart.kodenota')
            ->leftJoin('sparepart','sparepart.kodeSparepart','=','detiltransaksisparepart.kodeSparepart')
            ->where('transaksipenjualan.kodeNota', 'like', '%'.'SP'.'%')
            ->get();
        return view('transaksiSparepart/index', ['tSparepart'=>$transaksiSparepart, 'sparepart'=>$sparepart,'no'=>0, 'pegawai'=>$pegawai, 'noDetil'=>0]);

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

        $user = Auth::user();
        $pegawaiOnDuty = PegawaiOnDuty::create([
             'email'=> $user->email,
             'kodeNota'=>$transaksi->kodeNota
        ]);

       
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
