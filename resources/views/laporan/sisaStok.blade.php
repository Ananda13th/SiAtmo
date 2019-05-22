@extends('layouts.owner')

@section('content')
<h4 class="mt2">Laporan Sisa Stok </h4>
<hr>

<form method="POST" action="{{ route('laporan.sisaStok') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group-row">
    <label>Tahun</label>
    <select id="tahun" name="tahun" class="custom-select">
            <option value="2019">2019</option>
    </select>
    <br>
    <label>Sparepart </label>
    <select id="tipe" name="tipe" class="custom-select">
        @foreach($spareparts as $sparepart)
            <option value="{{$sparepart->tipeSparepart}}">{{$sparepart->namaSparepart}}</option>
        @endforeach
    </select>
    <br>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Lihat</button>
</form>
@endsection
