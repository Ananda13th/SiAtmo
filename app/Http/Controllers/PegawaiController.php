<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posisi;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::leftJoin('posisi','posisi.idPosisi','=','users.idPosisi')->get();
        return view('pegawai/index', ['users'=>$pegawai, 'no'=>0]);
    }

    public function create()
    {
        $posisi = Posisi::all();
        return view('pegawai/create',['posisi'=>$posisi]);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:25',
            'email'=>'required',
            'password'=>'required|min:6|max:10',
            'nomorTelpon'=>'required|max:12',
            'gaji'=>'required',
            'idCabang'=>'required',
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


        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambah');
    }

    public function edit($email)
    {
        $pegawai = User::find($email);
        
        return view('pegawai/edit',['users'=>$pegawai]);
    }

    public function show($email)
    {
        $pegawai = User::find($email);

        return redirect()->route('pegawai.index');
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

  
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diedit');
    }

    public function destroy($email)
    {
        $pegawai = User::findOrFail($email);
        dd($pegawai);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }

  
}
