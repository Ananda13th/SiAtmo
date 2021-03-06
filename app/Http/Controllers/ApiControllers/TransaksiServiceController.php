<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

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

class TransaksiServiceController extends Controller
{
    public function index()
    {
        $transaksiService   = TransaksiPenjualan::leftJoin('detiltransaksiservice','transaksipenjualan.kodenota','=','detiltransaksiservice.kodenota')
            ->leftJoin('kendaraankonsumen','kendaraankonsumen.platNomorKendaraan','=','detiltransaksiservice.platNomorKendaraan')
            ->leftJoin('service','service.kodeService','=','detiltransaksiservice.kodeService')->where('transaksipenjualan.kodeNota', 'like', '%'.'SV'.'%')
            ->get();
            return response()->json(($transaksiService), 200);

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
        $kode       = 'SV';
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
            'kodeNota'          =>$kodeNota,
            'tanggalTransaksi'  =>Carbon::now(), 
            'statusTransaksi'   =>'Sedang Dikerjakan',
            'subtotal'          =>$subtotal, 
            'total'             =>$subtotal,
            'namaKonsumen'      =>$request->namaKonsumen, 
            'noTelpKonsumen'    =>$request->noTelpKonsumen, 
            'alamatKonsumen'    =>$request->alamatKonsumen,
        ]);

        $user = Auth::user();
        $pegawaiOnDuty = PegawaiOnDuty::create([
            'emailPegawai'=> $user->email,
            'kodeNota'=>$transaksi->kodeNota
        ]);

        $count = count($request->kodeService);
        for($i = 0; $i<$count; $i++)
        {
            $detiltransaksi = DetilTransaksiService::create([
                'kodeNota'              =>$kodeNota,
                'biayaServiceTransaksi' =>$request->biayaServiceTransaksi[$i], 
                'platNomorKendaraan'    =>$request->platNomorKendaraan[$i], 
                'emailPegawai'          =>$request->emailPegawai[$i], 
                'kodeService'           =>$request->kodeService[$i]
            ]);
        }
        $response = "Sukses";

        return response()->json(($response), 201);
    }

    public function edit($kodeNota)
    {
        $dataNota = TransaksiService::find($kodeNota);

        return view('transaksiService.edit', ['dataNota'=>$dataNota]);

    }

    public function downloadPDFLunas($kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        $user = Auth::user();
        $pdf = PDF::loadView('pdf.notaLunasService', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
        return $pdf->stream();
    }


    public function printPreview($kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        // $user = Auth::user();

        // return response()->json($detil, 200);
      return view('printPreview.notaLunasServiceMobile', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
    }

    public function printPreviewSPK($kodeNota)
    {
        $tService = TransaksiPenjualan::find($kodeNota);
        $detil = DetilTransaksiService::leftJoin('service', 'detiltransaksiservice.kodeService', '=', 'service.kodeService')
        ->leftJoin('users', 'detiltransaksiservice.emailPegawai', '=', 'users.email')
        ->get();
        $user = Auth::user();
        dd($user);

      return view('printPreview.SPKServiceMobile', ['data'=>$tService, 'detil'=>$detil, 'pegawai'=>$user]);
    }
}
