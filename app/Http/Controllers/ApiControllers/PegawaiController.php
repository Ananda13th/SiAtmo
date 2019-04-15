<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\User;
use App\Posisi;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::leftJoin('posisi','posisi.idPosisi','=','users.idPosisi')->get();
        $response = "OK";
        return response()->json(($pegawai), 200);
    }

    public function create()
    {
        $posisi = Posisi::all();
        return json_encode(array("posisi"=>$posisi));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:25',
            'email'=>'required',
            'password'=>'required|min:6|max:10',
            'nomorTelpon'=>'required|max:12',
            'gaji'=>'required',
            'idCabang'=>'required'
        ],
        [
            'password.required'=>'Password harus 6-10 karakter',
        ]);
        
        $registrasi = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password),
            'nomorTelpon'=> $request['nomorTelpon'],
            'gaji' => $request['gaji'],
            'idPosisi' => $request['idPosisi'],
            'idCabang' => $request['idCabang']
        ]);


        return response()->json($registrasi, 201);

    }

    public function edit($email)
    {
        $pegawai = User::find($email);
        
        return json_encode(array("pegawai"=>$pegawai));

    }

    public function show($email)
    {
        $pegawai = User::find($email);

        return json_encode(array("pegawai"=>$pegawai));
    }

    public function update(Request $request, $email)
    {
        $this->validate($request, [
            'name'=>'required|max:25',
            'nomorTelpon'=>'required|max:12',
            'gaji'=>'required',
            'idCabang'=>'required',
        ],
        [
            'password.required'=>'Password harus 6-10 karakter',
        ]);
        
        $pegawai = User::find($email);
        $pegawai->name= $request['name'];
        $pegawai->nomorTelpon=$request['nomorTelpon'];
        $pegawai->gaji=$request['gaji'];
        $pegawai->idCabang=$request['idCabang'];
        $pegawai->update();

  
        return response()->json($pegawai, 200);
    }

    public function destroy($email)
    {
        $pegawai = User::find($email);
        $pegawai->delete();
        return response()->json($pegawai, 200);
    }

  
}
