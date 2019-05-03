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
        $pemesanan = Pemesanan::orderBy('statusPemesanan', 'DESC')->get();
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
           
        }

        return redirect()->route('pemesanan.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit($noPemesanan)
    {
        $detilPesan     = Pemesanan::find($noPemesanan);
        $sparepart      = Sparepart::all();
        $detilBarang    = DetilPemesanan::where('noPemesanan', '=', $noPemesanan) 
        ->leftJoin('sparepart', 'detilpemesanan.kodeSparepart', '=', 'sparepart.kodeSparepart')
        ->get();
        return view('pemesanan/edit', ['pemesanan'=>$detilPesan, 'detil'=>$detilBarang, 'sparepart'=>$sparepart]); 
    }

    public function show($noPemesanan)
    {
        return redirect()->route('pemesanan.index');
    }

    public function update(Request $request, $noPemesanan)
    {
        $pemesanan  = Pemesanan::where('noPemesanan', $noPemesanan)->first();
        $countSparepart = count($request->kodeSparepart);
        for($i=0;$i<$countSparepart;$i+1)
        {
            DetilPemesanan::updateOrCreate(['noPemesanan', $request->noPemesanan], [
                'noPemesanan'       =>$pemesanan->noPemesanan, 
                'jumlahPemesanan'   =>$request->jumlahPemesanan[$i], 
                'satuan'            =>$request->satuan[$i], 
                'kodeSparepart'     =>$request->kodeSparepart[$i] 
            ]);

        }
        return redirect()->route('pemesanan.index');
    }


    public function endPesanan($noPemesanan)
    {
        $detilPesan = DetilPemesanan::where('noPemesanan', $noPemesanan)->get();
        $jumlah = $detilPesan->count();
        $pemesanan = Pemesanan::find($noPemesanan);
        $pemesanan->statusPemesanan = "Arrived";
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
        $pemesanan->statusPemesanan = "Shipping";
        $pemesanan->update();

        $pdf = PDF::loadView('pdf.pemesanan', ['data'=>$pemesanan, 'detil'=>$detilPesan, 'supplier'=>$supplier]);
        return $pdf->stream();
  
      }
}
