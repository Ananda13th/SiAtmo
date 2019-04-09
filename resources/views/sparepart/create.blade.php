@extends('layouts.owner')

@section('content')
<h4 class="mt2">Tambah Sparepart</h4>
<hr>

@if ($message = Session::get('failed'))
<div class="alert alert-danger mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger pb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('sparepart.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaSparepart" name="namaSparepart">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Kode</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="kodeSparepart" name="kodeSparepart">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Tipe</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="tipeSparepart" name="tipeSparepart">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Merk</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="merkSparepart" name="merkSparepart">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Harga Jual</label>
        <div class="col-sm-4">
            <input class="form-control" type="number" id="hargaJual" name="hargaJual">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Harga Beli</label>
        <div class="col-sm-4">
            <input class="form-control" type="number" id="hargaBeli" name="hargaBeli">
        </div>
    </div>
    <div class="form-group-row">
        <label for="posisi" class="col-sm-2 col-form-label">Peletakan</label>
        <select class="custom-select" id="tempatPeletakan" name="tempatPeletakan">
            <option value=" ">-Pilih Tempat-</option>
            <option value="DPN"> Depan </option>
            <option value="TGH"> Tengah </option>
            <option value="BLK"> Belakang </option>
        </select>
    </div>
    <br>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Jumlah Stok</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="jumlahStok" name="jumlahStok" value=0>
        </div>
    </div>
    <div class="form-group row">
        <label for="author">Gambar:</label>
        <input type="file" class="form-control" name="gambarSparepart"/>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
</form>
@endsection
