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
use DB;

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
        $kode       = 'SS';
        $tanggal    = Carbon::now()->format('dmy');
        $id         = [];
        $id = DB::select(" SELECT kodeNota FROM transaksipenjualan WHERE kodeNota LIKE '%$kode%' AND kodeNota LIKE '%$tanggal%' ORDER BY SUBSTRING(kodeNota, 11) + 0 DESC LIMIT 1");
        
        if(!$id)
            $no = 1;
        else{
            $no_str = substr($id[0]->kodeNota, 10);
            $no = ++$no_str;
        }
        $kodeNota = $kode.'-'.$tanggal.'-'.$no;

        $this->validate($request, [
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
            $subtotalSparepart += $request->hargaJualTransaksi[$i]*$request->jumlahSparepart[$i];
        }

        for($i = 0; $i<$countSubtotalService; $i++)
        {
            $subtotalService += $request->biayaServiceTransaksi[$i];
        }

        $subtotal= $subtotalService+$subtotalSparepart;
        $total=$subtotal;

        $transaksi = TransaksiPenjualan::create([
            'kodeNota'=>$kodeNota,
            'tanggalTransaksi'=>Carbon::now(), 
            'statusTransaksi'=>'Sedang Dikerjakan',
            'subtotal'=>$subtotal, 
            'total'=>$total,
            'namaKonsumen'=>$request->namaKonsumen, 
            'noTelpKonsumen'=>$request->noTelpKonsumen, 
            'alamatKonsumen'=>$request->alamatKonsumen,
        ]);

        $user = Auth::user();
        $pegawaiOnDuty = PegawaiOnDuty::create([
            'emailPegawai'=> $user->email,
            'kodeNota'=>$kodeNota
        ]);

        dd($pegawaiOnDuty);

        for($i = 0; $i<$countSubtotalSparepart; $i++)
        {
            $detiltransaksi = DetilTransaksiSparepart::create([
                'kodeNota'=>$kodeNota,
                'hargaJualTransaksi'=>$request->hargaJualTransaksi[$i], 
                'jumlahSparepart'=>$request->jumlahSparepart[$i], 
                'kodeSparepart'=>$request->kodeSparepart[$i]
            ]);
        }
        for($i = 0; $i<$countSubtotalService; $i++)
        {
            $detiltransaksi = DetilTransaksiService::create([
                'kodeNota'=>$kodeNota,
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
    public function printPreviewSPK($kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil1 = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        $detil2 = DetilTransaksiSparepart::leftJoin('sparepart', 'detiltransaksisparepart.kodeSparepart', '=', 'sparepart.kodeSparepart')->get();
        $user = Auth::user();
        return view('printPreview.notaLunasFull', ['data'=>$tService, 'detil1'=>$detil1,'detil2'=>$detil2, 'pegawai'=>$user]);
    }

}
