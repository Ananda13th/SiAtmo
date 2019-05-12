@extends('layouts.owner')

@section('content')
<h4 class="mt2">Laporan Sisa Stok </h4>
<hr>

<form method="POST" action="{{ route('laporan.sisaStok') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group-row">
    <label>Sparepart </label>
    <select id="kode" name="kode" class="custom-select">
        @foreach($spareparts as $sparepart)
            <option value="{{$sparepart->kodeSparepart}}">{{$sparepart->namaSparepart}}</option>
        @endforeach
    </select>
    <br>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Lihat</button>
</form>
@endsection
