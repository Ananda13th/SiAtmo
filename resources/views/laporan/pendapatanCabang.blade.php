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

<form method="POST" action="{{ route('laporan.cabang') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group-row">
        <label for="cabang" class="col-sm-2 col-form-label">Cabang</label>
        <select class="custom-select" id="cabang" name="cabang">
            <option value="">-Pilih Cabang-</option>
            @foreach($cabang as $cabang)
                <option value="{{$cabang->idCabang}}"> {{$cabang->namaCabang}} </option>
            @endforeach
        </select>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Cari </button>
@endsection
