<?php

namespace SiAtmo\Http\Controllers;

use Illuminate\Http\Request;
use SiAtmo\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();

        return view('supplier/index', ['supplier'=>$supplier, 'no'=>0]);
    }

    public function create()
    {
        $supplier = Supplier::all();
        return view('supplier/create', ['supplier'=>$supplier]);
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


        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambah');
    }

    public function edit($namaPerusahaan)
    {
        $supplier = Supplier::find($namaPerusahaan);
        
        return view('supplier/edit',['supplier'=>$supplier]);
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

  
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diedit');
    }

    public function destroy($namaPerusahaan)
    {
        $supplier = Supplier::find($namaPerusahaan);
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus');
    }
}
