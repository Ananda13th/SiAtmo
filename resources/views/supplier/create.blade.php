@extends('layouts.owner')

@section('content')
<br>
<h4 class="mt2">Tambah Supplier </h4>
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
<form method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Perusahaan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaPerusahaan" name="namaPerusahaan">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Alamat</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="alamatSupplier" name="alamatSupplier">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Sales</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaSales" name="namaSales">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telp Sales</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="noTelpSales" name="noTelpSales">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i>Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i>Batal</button>
</form>
@endsection
