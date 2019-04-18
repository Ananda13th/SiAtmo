<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use SiAtmo\Kendaraan;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::all();

        return response()->json(($kendaraan), 200);
    }

    public function create()
    {
        $kendaraan = Kendaraan::all();
        return json_encode(array("data"=>$kendaraan));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'merkKendaraan'=>'required',
            'tipeKendaraan'=>'required',
        ]
        );
        
        $kendaraan = Kendaraan::create([
            'merkKendaraan'=>$request->merkKendaraan,
            'tipeKendaraan'=>$request->tipeKendaraan,
        ]);


        return response()->json($service, 201);
    }

    public function edit($kodeKendaraan)
    {
       
        $kendaraan = Kendaraan::find($kodeKendaraan);
        
        return json_encode(array("data"=>$kendaraan));
    }

    public function show($kodeKendaraan)
    {

        return redirect()->route('kendaraan.index');
    }

    public function update(Request $request, $kodeKendaraan)
    {
        $this->validate($request, [
            'merkKendaraan'=>'required',
            'tipeKendaraan'=>'tipeKendaraan',
        ]);
        
        $kendaraan = Kendaraan::find($kodeKendaraan);
        $kendaraan->merkKendaraan = $request['merkKendaraan'];
        $kendaraan->tipeKendaraan = $request['tipeKendaraan'];
        $kendaraan->update();

  
        return response()->json($service, 200);
    }

    public function destroy($kodeKendaraan)
    {
        $kendaraan = Kendaraan::find($kodeKendaraan);
        $kendaraan->delete();
        return response()->json($service, 200);
    }
}
