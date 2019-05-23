<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\Sparepart;
use Exception;
use Image;
use DB;

class SparepartController extends Controller
{
    public function index()
    {
        $sparepart= Sparepart::all();

        return view('sparepart/index', ['sparepart'=>$sparepart, 'no'=>0]);
    }

    public function ByHarga()
    {
        $sparepart= Sparepart::orderBy('hargaJual')->get();

        return view('sparepart/index', ['sparepart'=>$sparepart, 'no'=>0]);
    }

    public function ByStok()
    {
        $sparepart= Sparepart::orderBy('jumlahStok')->get();

        return view('sparepart/index', ['sparepart'=>$sparepart, 'no'=>0]);
    }

    public function create()
    {
        $sparepart= Sparepart::all();
        return view('sparepart/create',['sparepart'=>$sparepart]);
    }

    public function store(Request $request)
    {
        $tempat         = $request->tempatPeletakan;
        $penyimpanan    = $request->tempatSimpan;
        $id             = [];
        $id = DB::select(" SELECT kodeSparepart FROM sparepart WHERE kodeSparepart LIKE '%$tempat%' AND kodeSparepart LIKE '%$penyimpanan%' ORDER BY SUBSTRING(kodeSparepart, 11) + 0 DESC LIMIT 1");
        if(!$id)
            $no = 1;
        else{
            $no_str = substr($id[0]->kodeSparepart, 10);
            $no     = ++$no_str+1;
        }
        $kodeBarang = $tempat.'-'.$penyimpanan.'-'.$no;

        $this->validate($request, [
            'namaSparepart'=>'required',
            'tipeSparepart'=>'required',
            'merkSparepart'=>'required',
            'hargaJual'=>'required',
            'hargaBeli'=>'required',
            'tempatPeletakan'=>'required',
            'jumlahStok'=>'required',
            'gambarSparepart'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('gambarSparepart'))
        {
            $file = $request->file('gambarSparepart');
            $image = $file->openFile()->fread($file->getSize());
            // $image = $request->file('gambarSparepart');
            // $filename = time() .$image->getClientOriginalName();
            // $image->move( public_path().'/image/',  $filename );
            try{
                $addSparepart = Sparepart::create([
                    'kodeSparepart' => $kodeBarang,
                    'namaSparepart'=>$request->namaSparepart,
                    'tipeSparepart'=>$request->tipeSparepart,
                    'merkSparepart'=>$request->merkSparepart,
                    'hargaJual'=>$request->hargaJual,
                    'hargaBeli'=>$request->hargaBeli,
                    'tempatPeletakan'=>$request->tempatPeletakan,
                    'jumlahStok'=>$request->jumlahStok,
                    'gambarSparepart'=>$image
                ]);
            }
            catch(Exception $exception)
            {
                return redirect()->route('sparepart.create')->with('failed','Kode Sparepart Sudah Ada');
            }
        }
        else
        {
            try{
                $addSparepart = Sparepart::create([
                    'kodeSparepart' => $kodeBarang,
                    'namaSparepart'=>$request->namaSparepart,
                    'tipeSparepart'=>$request->tipeSparepart,
                    'merkSparepart'=>$request->merkSparepart,
                    'hargaJual'=>$request->hargaJual,
                    'hargaBeli'=>$request->hargaBeli,
                    'tempatPeletakan'=>$request->tempatPeletakan,
                    'jumlahStok'=>$request->jumlahStok
                ]);
            }
            catch(Exception $exception)
            {
                return redirect()->route('sparepart.create')->with('failed','Kode Sparepart Sudah Ada');
            }
        };
        return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil ditambah');
    }

    public function edit($kodeSparepart)
    {
        $sparepart = Sparepart::find($kodeSparepart);
        
        return view('sparepart/edit',['sparepart'=>$sparepart]);
    }

    public function show($kodeSparepart)
    {
        $sparepart = Sparepart::find($kodeSparepart);

        return redirect()->route('sparepart.index');
    }

    public function update(Request $request, $kodeSparepart)
    {
        $this->validate($request, [
            'namaSparepart'=>'required',
            'tipeSparepart'=>'required',
            'merkSparepart'=>'required',
            'hargaJual'=>'required',
            'hargaBeli'=>'required',
        ]);
        
        $sparepart = Sparepart::find($kodeSparepart);
        $sparepart->namaSparepart= $request['namaSparepart'];
        $sparepart->tipeSparepart=$request['tipeSparepart'];
        $sparepart->merkSparepart=$request['merkSparepart'];
        $sparepart->hargaJual=$request['hargaJual'];
        $sparepart->hargaBeli=$request['hargaBeli'];
        $sparepart->update();
        return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil diedit');
    }

    public function destroy($kodeSparepart)
    {
        $sparepart = Sparepart::findOrFail($kodeSparepart);
        try{
            $sparepart->delete();
            return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil dihapus');
        }
        catch(Exception $exception)
        {
            return redirect()->route('sparepart.index')->with('failed', 'Sparepart gagal dihapus');
        }
    }
}
