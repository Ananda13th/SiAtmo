<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\Pemesanan;
use SiAtmo\DetilPemesanan;
use SiAtmo\Sparepart;
use SiAtmo\Supplier;
use Carbon\Carbon;
use SiAtmo\HistorySparepart;
use PDF;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::all();
        return view('pemesanan/index', ['pemesanan'=>$pemesanan, 'no'=>0, ]);
    }

    public function create()
    {
        $sparepart   = Sparepart::all();
        $supplier    = Supplier::all();
        return view('pemesanan/create', ['sparepart'=>$sparepart, 'supplier'=>$supplier]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            
        ]);
        $countPemesanan=count($request->kodeSparepart);
        $pemesanan = Pemesanan::create([
            'tanggalPemesanan'=>Carbon::now(),
            'statusPemesanan'=>'sedang dikirim', 
            'namaPerusahaan'=>$request->namaPerusahaan
        ]);
        
        $countPemesanan=count($request->kodeSparepart);
        for($i = 0;$i<$countPemesanan;$i++)
        {
            DetilPemesanan::create([
                'noPemesanan'       =>$pemesanan->noPemesanan, 
                'jumlahPemesanan'   =>$request->jumlahPemesanan[$i], 
                'satuan'            =>$request->satuan[$i], 
                'kodeSparepart'     =>$request->kodeSparepart[$i] 
            ]);

            HistorySparepart::create([
                'jumlah'        =>$request->jumlahPemesanan[$i], 
                'kodeSparepart' =>$request->kodeSparepart[$i],
                'tanggal'       =>Carbon::now()
            ]);
        }

        return redirect()->route('pemesanan.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit($noPemesanan)
    {
        $detilPesan = Pemesanan::where('pemesanan.noPemesanan', '=', $noPemesanan)->first();
        $sparepart   = Sparepart::all();
        $supplier    = Supplier::all();
        
        $detilBarang = DetilPemesanan::where('noPemesanan', '=', $noPemesanan)->get();
        return view('pemesanan/edit', ['pemesanan'=>$detilPesan, 'detil'=>$detilBarang, 'sparepart'=>$sparepart, 'supplier'=>$supplier]); 
    }

    public function show($noPemesanan)
    {
        return redirect()->route('pemesanan.index');
    }

    public function update(Request $request, $noPemesanan)
    {
        $pemesanan  = Pemesanan::find($noPemesanan)->leftJoin('detilpemesanan', 'pemesanan.noPemesanan', '=', 'detilpemesanan.noPemesanan')->get();
        $detilpesan = DetilPemesanan::find($noPemesanan);
        
        $countSparepart = count($request->kodeSparepart);

        for($i=0;$i<$countSparepart;$i+1)
        {
            DetilPemesanan::create([
                'noPemesanan'       =>$pemesanan->noPemesanan, 
                'jumlahPemesanan'   =>$request->jumlahPemesanan[$i], 
                'satuan'            =>$request->satuan[$i], 
                'kodeSparepart'     =>$request->kodeSparepart[$i] 
            ]);

        }
        return redirect()->route('pemesanan.index');
    }

    public function endPesan($noPemesanan)
    {
        $pemesanan = Pemesanan::find($noPemesanan);
        $pemesanan->statusPemesanan = "selesai";
        $pemesanan->update();
        return redirect()->route('pemesanan.index');
    }

    public function destroy($noPemesanan)
    {
        $detil = DetilPemesanan::all();
        for($i=0;$i<count($detil);$i++)
        {
            if($detil[$i]->noPemesanan == $noPemesanan)
            {
                $detil[$i]->delete();
            }
        }
        $pemesanan  = Pemesanan::find($noPemesanan);
        $pemesanan->delete();
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dihapus');

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
