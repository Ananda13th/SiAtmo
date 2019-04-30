@extends('layouts.owner')

@section('content')
<h4 class="mt2">Edit Pegawai</h4>
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

{{ Form::model($users, ['method' => 'PATCH', 'route'=>['pegawai.update', $users->email]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="name" name="name" value="{{$users['name']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telp</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="nomorTelpon" name="nomorTelpon" value="{{$users['nomorTelpon']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Gaji</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="gaji" name="gaji" value="{{$users['gaji']}}">
        </div>
    </div>
    <div class="form-group-row">
        <label for="cabang" class="col-sm-2 col-form-label">Cabang</label>
        <select class="custom-select" id="idCabang" name="idCabang">
            <option value="">-Pilih Cabang-</option>
            <option value=1> Babarsari </option>
            <option value=2> Nologaten </option>
        </select>
    </div>
    <br>
    <button type="submit" class="btn btn-sm btn-danger"><i class="oi oi-trash"></i> Simpan</button>
    <button type="reset" class="btn btn-sm btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
{{ Form::close() }}
@endsection
