<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::all();

        return response()->json(($serice), 200);
    }

    public function create()
    {
        $service = Service::all();
        return json_encode(array("data"=>$service));
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


        return response()->json($service, 201);
    }

    public function edit($kodeService)
    {
       
        $service = Service::find($kodeService);
        
        return json_encode(array("data"=>$service));
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

  
        return response()->json($service, 200);
    }

    public function destroy($kodeService)
    {
        $service = Service::find($kodeService);
        $service->delete();
        return response()->json($service, 200);
    }
}
