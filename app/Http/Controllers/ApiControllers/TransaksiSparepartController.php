<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

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
        $sparepart=DetilTransaksiSparepart::all();
        
        $transaksiSparepart   = TransaksiPenjualan::leftJoin('detiltransaksisparepart','transaksipenjualan.kodenota','=','detiltransaksisparepart.kodenota')
            ->leftJoin('sparepart','sparepart.kodeSparepart','=','detiltransaksisparepart.kodeSparepart')
            ->where('transaksipenjualan.kodeNota', 'like', '%'.'SP'.'%')
            ->get();
        
            return response()->json(($transaksiSparepart), 200);

    }

    public function create()
    {
        $sparepart      = Sparepart::all();
        $tanggal        = Carbon::now();
        $daftarKode     = TransaksiPenjualan::all()->where('transaksipenjualan.kodeNota', 'like', '%'.'SP'.'%' , 'AND', 'transaksipenjualan.tanggalTransaksi', 'like', '%'.$tanggal.'%')->get()->count();
        return view('transaksiSparepart/create', ['sparepart'=>$sparepart, 'daftarKode'=>$daftarKode]);
    }

    public function store(Request $request)
    {
        $kode       = 'SP';
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
        
        $countSubtotal = count($request->hargaJualTransaksi);
        $subtotal=0;
        for($i = 0; $i<$countSubtotal; $i++)
        {
            $subtotal += $request->hargaJualTransaksi[$i]*$request->jumlahSparepart[$i];
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
             'emailPegawai' => $user->email,
             'kodeNota'     =>$transaksi->kodeNota
        ]);

        $count = count($request->kodeSparepart);
        for($i = 0; $i<$count; $i++)
        {
            $jumlah = $request->jumlahSparepart[$i]*-1;
            HistorySparepart::create([
                'jumlah'        =>$jumlah, 
                'kodeSparepart' =>$request->kodeSparepart[$i],
                'tanggal'       =>Carbon::now()
            ]);

            Sparepart::where('kodeSparepart', '=', $request->kodeSparepart[$i])->decrement('jumlahStok', $request->jumlahSparepart[$i]);
            $detiltransaksi = DetilTransaksiSparepart::create([
                'kodeNota'          =>$kodeNota,
                'hargaJualTransaksi'=>$request->hargaJualTransaksi[$i], 
                'jumlahSparepart'   =>$request->jumlahSparepart[$i], 
                'kodeSparepart'     =>$request->kodeSparepart[$i]
            ]);

        }
        $response = "Sukses";

        return response()->json(($response), 201);
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
