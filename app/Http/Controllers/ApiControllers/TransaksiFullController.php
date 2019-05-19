<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

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
        $transaksiFull = TransaksiPenjualan::leftJoin('detiltransaksisparepart','transaksipenjualan.kodenota','=','detiltransaksisparepart.kodenota')
            ->leftJoin('detiltransaksiservice','transaksipenjualan.kodenota','=','detiltransaksiservice.kodenota')
            // ->leftJoin('sparepart','sparepart.kodeSparepart','=','detiltransaksisparepart.kodeSparepart')
            ->leftJoin('kendaraankonsumen','kendaraankonsumen.platNomorKendaraan','=','detiltransaksiservice.platNomorKendaraan')
            ->leftJoin('service','service.kodeService','=','detiltransaksiservice.kodeService')
            ->get();
        // return view('transaksiFull/index', ['tSparepart'=>$transaksiFull, 'no'=>0, ]);
        return response()->json($transaksiFull, 200);
    }

    public function showIndex(Request $request) {
            $transaksiFull = TransaksiPenjualan::leftJoin('detiltransaksisparepart','transaksipenjualan.kodenota','=','detiltransaksisparepart.kodenota')
            ->leftJoin('detiltransaksiservice','transaksipenjualan.kodenota','=','detiltransaksiservice.kodenota')
            ->leftJoin('sparepart','sparepart.kodeSparepart','=','detiltransaksisparepart.kodeSparepart')
            ->leftJoin('kendaraankonsumen','kendaraankonsumen.platNomorKendaraan','=','detiltransaksiservice.platNomorKendaraan')
            ->leftJoin('service','service.kodeService','=','detiltransaksiservice.kodeService')
            ->where('kendaraankonsumen.platNomorKendaraan', $request->platNomorKendaraan)
            ->where('transaksipenjualan.noTelpKonsumen', $request->noTelpKonsumen)
            ->get();
    
        // return view('transaksiFull/index', ['tSparepart'=>$transaksiFull, 'no'=>0, ]);
        return response()->json($transaksiFull, 200);
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
          
        $countSubtotalSparepart = count($request->hargaJualTransaksi);
        $subtotalSparepart=0;
        for($i = 0; $i<$countSubtotalSparepart; $i++)
        {
            $subtotalSparepart += $request->hargaJualTransaksi[$i]*$request->hargaJualTransaksi[$i];
        }

        $countSubtotalService = count($request->biayaServiceTransaksi);
        $subtotalService=0;
        for($i = 0; $i<$countSubtotal; $i++)
        {
            $subtotalService += $request->biayaServiceTransaksi[$i];
        }

        $total= $subtotalService+$subtotalSparepart;

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
            'kodeNota'=>$transaksi->kodeNota
        ]);

        $count = count($request->kodeSparepart);
        for($i = 0; $i<$count; $i++)
        {
            $detiltransaksi = DetilTransaksiSparepart::create([
                'kodeNota'=>$transaksi->kodeNota,
                'hargaJualTransaksi'=>$request->hargaJualTransaksi[$i], 
                'jumlahSparepart'=>$request->jumlahSparepart[$i], 
                'kodeSparepart'=>$request->kodeSparepart[$i]
            ]);
        }

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
