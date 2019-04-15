<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Sparepart;

class SparepartController extends Controller
{
    public function index()
    {
        $sparepart= Sparepart::all();

        return response()->json(($sparepart), 200);
    }

    public function create()
    {
        $sparepart= Sparepart::all();
        return json_encode(array("data"=>$sparepart));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kodeSparepart'=>'required|max:12|min:12',
            'namaSparepart'=>'required',
            'tipeSparepart'=>'required',
            'merkSparepart'=>'required',
            'hargaJual'=>'required',
            'hargaBeli'=>'required',
            'tempatPeletakan'=>'required',
            'jumlahStok'=>'required',
        ]);
        
        $addSparepart = Sparepart::create([
            'kodeSparepart' => $request->kodeSparepart,
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
        // $pegawai = User::findOrFail($email);
        // $pegawai->update($request->all());
        return response()->json($service, 200);
    }

    public function destroy($kodeSparepart)
    {
        $sparepart = Sparepart::find($kodeSparepart);
        $sparepart->delete();
        return response()->json($service, 200);
    }
}
