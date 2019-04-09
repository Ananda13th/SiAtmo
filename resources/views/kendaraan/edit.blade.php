@extends('layouts.owner')

@section('content')
<h4 class="mt2">Edit Kendaraan</h4>
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

{{ Form::model($kendaraan, ['method' => 'PATCH', 'route'=>['kendaraan.update', $kendaraan->kodeKendaraan]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Perusahaan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="merkKendaraan" name="merkKendaraan" value="{{$kendaraan['merkKendaraan']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Alamat Perusahaan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="tipeKendaraan" name="tipeKendaraan" value="{{$kendaraan['tipeKendaraan']}}">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-sm btn-danger"><i class="oi oi-trash"></i> Simpan</button>
    <button type="reset" class="btn btn-sm btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
     {{ Form::close() }}
@endsection
