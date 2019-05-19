<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use SiAtmo\Pemesanan;
use SiAtmo\DetilPemesanan;
use SiAtmo\Sparepart;
use SiAtmo\Supplier;
use Carbon\Carbon;
use PDF;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::all();
        return response()->json(($pemesanan), 200);
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
            
    //     ]);
    //     $countPemesanan=count($request->kodeSparepart);
    //     $pemesanan = Pemesanan::create([
    //         'tanggalPemesanan'=>Carbon::now(),
    //         'statusPemesanan'=>'sedang dikirim', 
    //         'namaPerusahaan'=>$request->namaPerusahaan
    //     ]);
        
    //     $countPemesanan=count($request->kodeSparepart);
    //     for($i = 0;$i<$countPemesanan;$i++)
    //     {
    //         DetilPemesanan::create([
    //             'noPemesanan'       =>$pemesanan->noPemesanan, 
    //             'jumlahPemesanan'   =>$request->jumlahPemesanan[$i], 
    //             'satuan'            =>$request->satuan[$i], 
    //             'kodeSparepart'     =>$request->kodeSparepart[$i] 
    //         ]);
    //     }
    //     $response = "Sukses";

    //     return response()->json(($response), 201);
    // }

    public function store(Request $request)
    {
        // $this->validate($request, [
            
        // ]);
        // $countPemesanan=count($request->kodeSparepart);
        $pemesanan = Pemesanan::create([
            'tanggalPemesanan'=>Carbon::now(),
            'statusPemesanan'=>'On Process', 
            'namaPerusahaan'=>$request->namaPerusahaan
        ]);
        
        // $countPemesanan=count($request->kodeSparepart);
        // for($i = 0;$i<$countPemesanan;$i++)
        // {
            DetilPemesanan::create([
                'noPemesanan'       =>$pemesanan->noPemesanan, 
                'jumlahPemesanan'   =>$request->jumlahPemesanan, 
                'satuan'            =>$request->satuan, 
                'kodeSparepart'     =>$request->kodeSparepart 
            ]);
        // }
        return response()->json(($pemesanan), 200);
    }

    public function addStore(Request $request) {
        $cek = Pemesanan::where('noPemesanan', $request->noPemesanan);

        // if($cek->statusPemesanan === 'Shipping' or $cek->statusPemesanan === 'Arrived') {
        //     return response()->json(error);
        // }
        // else {
            $addPemesanan = DetilPemesanan::create([
                'noPemesanan'       =>$request->noPemesanan, 
                'jumlahPemesanan'   =>$request->jumlahPemesanan, 
                'satuan'            =>$request->satuan, 
                'kodeSparepart'     =>$request->kodeSparepart 
            ]);
            
            return response()->json(($addPemesanan), 201);
        // }
    }

    // public function edit($noPemesanan)
    // {
    //     $detilPesan = Pemesanan::where('pemesanan.noPemesanan', '=', $noPemesanan)->first();
    //     $sparepart   = Sparepart::all();
    //     $supplier    = Supplier::all();
        
    //     $detilBarang = DetilPemesanan::where('noPemesanan', '=', $noPemesanan)->get();
    //     return view('pemesanan/edit', ['pemesanan'=>$detilPesan, 'detil'=>$detilBarang, 'sparepart'=>$sparepart, 'supplier'=>$supplier]); 
    // }

    // public function update(Request $request, $noPemesanan)
    // {
    //     $pemesanan  = Pemesanan::find($noPemesanan)->leftJoin('detilpemesanan', 'pemesanan.noPemesanan', '=', 'detilpemesanan.noPemesanan')->get();
    //     $detilpesan = DetilPemesanan::find($noPemesanan);
        
    //     $countSparepart = count($request->kodeSparepart);

    //     for($i=0;$i<$countSparepart;$i+1)
    //     {
    //         DetilPemesanan::create([
    //             'noPemesanan'       =>$pemesanan->noPemesanan, 
    //             'jumlahPemesanan'   =>$request->jumlahPemesanan[$i], 
    //             'satuan'            =>$request->satuan[$i], 
    //             'kodeSparepart'     =>$request->kodeSparepart[$i] 
    //         ]);

    //     }
    //     $response = "Sukses";
    //     return response()->json(($response), 200);
    // }

    public function show($noPemesanan)
    {
        return redirect()->route('pemesanan.index');
    }

    public function showDetil($noPemesanan)
    {
        $detil = DetilPemesanan::where('noPemesanan', $noPemesanan)->get();

        return response()->json($detil, 200);
    }

    public function updateStatus(Request $request, $noPemesanan) {
        $detilPesan = DetilPemesanan::where('noPemesanan', $noPemesanan)->get();
        $jumlah = $detilPesan->count();
        $pemesanan = Pemesanan::find($noPemesanan);
        $pemesanan->statusPemesanan = $request->statusPemesanan;
        $pemesanan->update();

        for($i=0;$i<$jumlah;$i++)
        {
            Sparepart::where('kodeSparepart', $detilPesan[$i]->kodeSparepart)->increment('jumlahStok', $detilPesan[$i]->jumlahPemesanan);
            HistorySparepart::create([
                'jumlah'        =>$detilPesan[$i]->jumlahPemesanan, 
                'kodeSparepart' =>$detilPesan[$i]->kodeSparepart,
                'tanggal'       =>Carbon::now()
            ]);
        }
        
        return response()->json($detilPesan, 200);
    }

    // public function endPesan($noPemesanan)
    // {
    //     $pemesanan = Pemesanan::find($noPemesanan);
    //     $pemesanan->statusPemesanan = "selesai";
    //     $pemesanan->update();
    //     $response = "Sukses";
    //     return response()->json(($response), 200);
    // }

    public function destroy($noPemesanan)
    {
        $pemesanan  = Pemesanan::find($noPemesanan);
        if($pemesanan->statusPemesanan === "Shipping" or $pemesanan->statusPemesanan === "Arrived") {
            return response()->json(error);
        }
        else {
            $pemesanan->delete();

            $detil = DetilPemesanan::where('noPemesanan', $noPemesanan)->first();
            $detil->delete();
         
            return response()->json(($detil), 200);
        }
    }

    public function downloadPDF($noPemesanan)
    {
        $pemesanan = Pemesanan::find($noPemesanan);
        $detilPesan = DetilPemesanan::leftJoin('sparepart', 'detilpemesanan.kodeSparepart', '=', 'sparepart.kodeSparepart')->get();
        $supplier = Supplier::all();
  
        $pdf = PDF::loadView('pdf.pemesanan', ['data'=>$pemesanan, 'detil'=>$detilPesan, 'supplier'=>$supplier]);
        return $pdf->stream();
  
      }
}
