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

<form method="POST" action="{{ route('laporan.pendapatanBulanan') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group-row">
        <label for="cabang" class="col-sm-2 col-form-label">Cabang</label>
        <select class="custom-select" id="tahun" name="tahun">
            <option value="">-Pilih Posisi-</option>
            <option value=2019> 2019 </option>
        </select>
    </div>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Cari </button>
@endsection
