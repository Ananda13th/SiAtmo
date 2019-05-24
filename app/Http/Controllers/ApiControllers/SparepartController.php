<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use SiAtmo\Sparepart;

class SparepartController extends Controller
{
    public function index()
    {
        $sparepart= Sparepart::all();

        return response()->json(($sparepart), 200);
    }

    public function kodeSparepart() {
        $sparepart =  Sparepart::all('kodeSparepart');

        return response()->json($sparepart, 200);
    }

    public function bystok()
    {
        $sparepart= Sparepart::orderBy("jumlahStok", "ASC")->get();

        return response()->json(($sparepart), 200);
    }

    public function byharga()
    {
        $sparepart= Sparepart::orderBy("hargaBeli", "ASC")->get();

        return response()->json(($sparepart), 200);
    }

    public function pushNotif() {
        $sparepart = Sparepart::where('jumlahStok', '<', 10)->get();

        return response()->json($sparepart, 200);
    }

    public function tipeSparepart() {
        $sparepart =  Sparepart::all('tipeSparepart');

        return response()->json($sparepart, 200);
    }

    public function create()
    {
        $sparepart= Sparepart::all();
        return json_encode(array("data"=>$sparepart));
    }

    public function store(Request $request)
    {
        $tempat         = $request->tempatPeletakan;
        $penyimpanan    = $request->tempatSimpan;
        $id             = [];
        $id = DB::select(" SELECT kodeSparepart FROM sparepart WHERE kodeSparepart LIKE '%$tempat%' AND kodeSparepart LIKE '%$penyimpanan%'");
        $test = count($id);
        $no = $test+1;
        if(!$id)
            $no = 1;

        $kodeBarang = $tempat.'-'.$penyimpanan.'-'.$no;

        $this->validate($request, [
            'namaSparepart'=>'required',
            'tipeSparepart'=>'required',
            'merkSparepart'=>'required',
            'hargaJual'=>'required',
            'hargaBeli'=>'required',
            'tempatPeletakan'=>'required',
            'jumlahStok'=>'required',
        ]);
        
        $addSparepart = Sparepart::create([
            'kodeSparepart' => $kodeBarang,
            'namaSparepart'=>$request->namaSparepart,
            'tipeSparepart'=>$request->tipeSparepart,
            'merkSparepart'=>$request->merkSparepart,
            'hargaJual'=>$request->hargaJual,
            'hargaBeli'=>$request->hargaBeli,
            'tempatPeletakan'=>$request->tempatPeletakan,
            'jumlahStok'=>$request->jumlahStok,
            'gambarSparepart'=>$request->gambarSparepart
        ]);


        return response()->json($addSparepart, 201);
    }

    public function edit($kodeSparepart)
    {
        $sparepart = Sparepart::find($kodeSparepart);
        
        return json_encode(array("data"=>$sparepart));
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

        return response()->json($sparepart, 200);
    }

    public function destroy($kodeSparepart)
    {
        $sparepart = Sparepart::find($kodeSparepart);
        if($sparepart)
            $sparepart->delete();
        else
            return response()->json(error);

        return response()->json($sparepart, 200);
    }
}