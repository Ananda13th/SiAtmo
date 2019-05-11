@extends('layouts.owner')

@section('content')
<h4 class="mt2">Laporan Sisa Stok </h4>
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

<form method="POST" action="{{ route('laporan.sisaStok') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group-row">
        <label for="sparepart" class="col-sm-2 col-form-label">Sparepart</label>
        <select class="custom-select" id="kode" name="kode">
            <option value="">-Pilih Sparepart-</option>
            foreach($sparepart as $sparepart)
            {
                <option value="{{$sparepart->kodeSparepart}}"> {{$sparepart->namaSparepart}} </option>
            }
        </select>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Cari </button>
</form>
@endsection
