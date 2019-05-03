<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\Kendaraan;
use SiAtmo\KendaraanKonsumen;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::all();

        return view('kendaraan/index', ['kendaraan'=>$kendaraan, 'no'=>0]);
    }

    public function create()
    {
        $kendaraan = Kendaraan::all();
        return view('kendaraan/create', ['kendaraan'=>$kendaraan]);
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


        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambah');
    }

    public function edit($kodeKendaraan)
    {
       
        $kendaraan = Kendaraan::find($kodeKendaraan);
        
        return view('kendaraan/edit',['kendaraan'=>$kendaraan]);
    }

    public function show($kodeKendaraan)
    {

        return redirect()->route('kendaraan.index');
    }

    public function update(Request $request, $kodeKendaraan)
    {
        $this->validate($request, [
            'merkKendaraan'=>'required',
            'tipeKendaraan'=>'required',
        ]);
        
        $kendaraan = Kendaraan::find($kodeKendaraan);
        $kendaraan->merkKendaraan = $request['merkKendaraan'];
        $kendaraan->tipeKendaraan = $request['tipeKendaraan'];
        $kendaraan->update();

  
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diedit');
    }

    public function destroy($kodeKendaraan)
    {
        $kendaraan = Kendaraan::find($kodeKendaraan);
        $kendaraan->delete();
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus');
    }

    public function createKonsumen()
    {
        $kendaraan = Kendaraan::all();
        return view('kendaraan/createKonsumen', ['kendaraan'=>$kendaraan]);
    }

    public function saveKendaraanKonsumen(Request $request)
    {
        $this->validate($request, [
            'platNomorKendaraan'=>'required',
            'merkKendaraan'=>'required',
        ]
        );
        try{
        $kendaraan = KendaraanKonsumen::create([
            'merkKendaraan'=>$request->merkKendaraan,
            'platNomorKendaraan'=>$request->platNomorKendaraan,
        ]);
        }
        catch(Exception $exception)
        {
            return redirect()->route('kendaraan.index')->with('failed','Plat Nomor Sudah Ada');
        }
        return view('cs');
    }
}
