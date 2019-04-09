@extends('layouts.owner')

@section('content')
<h4 class="mt2">Edit Supplier</h4>
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

{{ Form::model($supplier, ['method' => 'PATCH', 'route'=>['supplier.update', $supplier->namaPerusahaan]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Perusahaan</label>
        <div class="col-sm-4">
            <input disabled class="form-control" type="text" value="{{$supplier['namaPerusahaan']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Alamat Perusahaan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="alamatSupplier" name="alamatSupplier" value="{{$supplier['alamatSupplier']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Sales</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaSales" name="namaSales" value="{{$supplier['namaSales']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telpon Sales</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="noTelpSales" name="noTelpSales" value="{{$supplier['noTelpSales']}}">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-sm btn-danger"><i class="oi oi-trash"></i> Simpan</button>
    <button type="reset" class="btn btn-sm btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
     {{ Form::close() }}
@endsection
