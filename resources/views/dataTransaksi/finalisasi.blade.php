@extends('layouts.kasir')

@section('content')
<br>
<h4 class="mt2">Finalisasi Transaksi</h4>
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

{{ Form::model($dataNota, ['method' => 'PATCH', 'route'=>['transaksi.update', $dataNota->kodeNota]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Kode Nota</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="kodeNota" name="kodeNota" value="{{$dataNota['kodeNota']}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaKonsumen" name="namaKonsumen" value="{{$dataNota['namaKonsumen']}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telpon Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="noTelpKonsumen" name="noTelpKonsumen" value="{{$dataNota['noTelpKonsumen']}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Alamat Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="alamatKonsumen" name="alamatKonsumen" value="{{$dataNota['alamatKonsumen']}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Subtotal</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="subtotal" name="subtotal" value="{{$dataNota['subtotal']}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Diskon</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="diskon" name="diskon">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
    {{ Form::close() }}

@endsection
