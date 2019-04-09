@extends('layouts.owner')

@section('content')
<h4 class="mt2">Edit Sparepart</h4>
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

{{ Form::model($sparepart, ['method' => 'PATCH', 'route'=>['sparepart.update', $sparepart->kodeSparepart]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaSparepart" name="namaSparepart" value="{{$sparepart['namaSparepart']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Tipe</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="tipeSparepart" name="tipeSparepart" value="{{$sparepart['tipeSparepart']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Merk</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="merkSparepart" name="merkSparepart" value="{{$sparepart['merkSparepart']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Harga Beli</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="hargaBeli" name="hargaBeli" value="{{$sparepart['hargaBeli']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Harga Jual</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="hargaJual" name="hargaJual" value="{{$sparepart['hargaJual']}}">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-sm btn-danger"><i class="oi oi-trash"></i> Simpan</button>
    <button type="reset" class="btn btn-sm btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
     {{ Form::close() }}
@endsection
