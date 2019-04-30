@extends('layouts.owner')

@section('content')
<h4 class="mt2">Tambah Pegawai </h4>
<hr>

@if ($errors->any())
    <div class="alert alert-danger pb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="name" name="name">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Email</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="email" name="email">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Password</label>
        <div class="col-sm-4">
            <input class="form-control" type="password" id="password" name="password">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telp</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="nomorTelpon" name="nomorTelpon">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Gaji</label>
        <div class="col-sm-4">
            <input class="form-control" type="number" id="gaji" name="gaji">
        </div>
    </div>
    <div class="form-group-row">
        <label for="posisi" class="col-sm-2 col-form-label">Posisi</label>
        <select class="custom-select" id="idPosisi" name="idPosisi">
            <option value="">-Pilih Posisi-</option>
            @foreach($posisi as $p) {
                <option value="{{ $p['idPosisi']}}"> {{$p['keteranganPosisi']}} </option>";
            }
            @endforeach
        </select>
    </div>
    <div class="form-group-row">
        <label for="cabang" class="col-sm-2 col-form-label">Cabang</label>
        <select class="custom-select" id="idCabang" name="idCabang">
            <option value="">-Pilih Posisi-</option>
            <option value=1> Babarsari </option>
            <option value=2> Nologaten </option>
        </select>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
</form>
@endsection
