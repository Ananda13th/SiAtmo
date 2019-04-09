<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::all();

        return view('service/index', ['service'=>$service]);
    }

    public function create()
    {
        $service = Service::all();
        return view('service/create', ['service'=>$service]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'keterangan'=>'required',
            'biayaService'=>'required',
        ]
        );
        
        $service = Service::create([
            'keterangan'=>$request->keterangan,
            'biayaService'=>$request->biayaService,
        ]);


        return redirect()->route('service.index')->with('success', 'Jasa Service berhasil ditambah');
    }

    public function edit($kodeService)
    {
       
        $service = Service::find($kodeService);
        
        return view('service/edit',['service'=>$service]);
    }

    public function show($kodeService)
    {

        return redirect()->route('service.index');
    }

    public function update(Request $request, $kodeService)
    {
        $this->validate($request, [
            'keterangan'=>'required',
            'biayaService'=>'required',
        ]);
        
        $service = Service::find($kodeService);
        $service->keterangan = $request['keterangan'];
        $service->biayaService = $request['biayaService'];
        $service->update();

  
        return redirect()->route('service.index')->with('success', 'Jasa Service berhasil diedit');
    }

    public function destroy($kodeService)
    {
        $service = Service::find($kodeService);
        $service->delete();
        return redirect()->route('service.index')->with('success', 'Jasa Service berhasil dihapus');
    }
}
