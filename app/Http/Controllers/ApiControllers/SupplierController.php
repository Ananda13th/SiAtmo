<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();

        return json_encode(array("data"=>$supplier));
    }

    public function create()
    {
        $supplier = Supplier::all();
        return json_encode(array("data"=>$supplier));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'namaPerusahaan'=>'required',
            'alamatSupplier'=>'required',
            'namaSales'=>'required',
            'noTelpSales'=>'required'
        ]
        );
        
        $registrasi = Supplier::create([
            'namaPerusahaan'=>$request->namaPerusahaan,
            'alamatSupplier'=>$request->alamatSupplier,
            'namaSales'=>$request->namaSales,
            'noTelpSales'=>$request->noTelpSales
        ]);


        return response()->json($service, 201);
    }

    public function edit($namaPerusahaan)
    {
        $supplier = Supplier::find($namaPerusahaan);
        
        return json_encode(array("data"=>$supplier));
    }

    public function show($namaPerusahaan)
    {
        $supplier = Supplier::all();

        return redirect()->route('supplier.index');
    }

    public function update(Request $request, $namaPerusahaan)
    {
        $this->validate($request, [
            'alamatSupplier'=>'required',
            'namaSales'=>'required',
            'noTelpSales'=>'required'
        ]);
        
        $supplier = Supplier::find($namaPerusahaan);
        $supplier->alamatSupplier=$request['alamatSupplier'];
        $supplier->namaSales=$request['namaSales'];
        $supplier->noTelpSales=$request['noTelpSales'];
        $supplier->update();

  
        return response()->json($service, 200);
    }

    public function destroy($namaPerusahaan)
    {
        $supplier = Supplier::find($namaPerusahaan);
        $supplier->delete();
        return response()->json($service, 200);
    }
}
