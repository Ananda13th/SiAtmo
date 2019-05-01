@extends('layouts.cs')

@section('content')
<h4 class="mt2">Tambah Kendaraan</h4>
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
<form method="POST" action="{{ route('daftarKendaraanKonsumen/create') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Merk Kendaraan</label>
        <select class="custom-select" id="merkKendaraan" name="merkKendaraan">
            <option value="">-Pilih Merk-</option>
            @foreach($kendaraan as $k) {
                <option value="{{ $k['kodeKendaraan']}}"> {{$k['merkKendaraan']}} - {{$k['tipeKendaraan']}} </option>";
            }
            @endforeach
        </select>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Plat Kendaraan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="tipeKendaraan" name="platNomorKendaraan">
        </div>
    </div>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i>Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i>Batal</button>
</form>
@endsection
