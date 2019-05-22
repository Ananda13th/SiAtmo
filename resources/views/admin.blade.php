@extends('layouts.owner')

@section('content')
<style>
.cardview {
    width  : fit-content;
    border: 2px solid black;
    margin-top : 10px;
}
.table-invisible {
    border: 0;
}
td.invisible {
    border: none;
}
</style>
<table class="table-invisible">
    <tr>
    <td>
        <div class="cardview">
        <a href="{{route('laporan.pendapatanBulanan')}}">
            <img src="{{ asset('image/pendapatanBulanan.jpg') }}" style="width:100%">
        </a>
        </div>
    </td>
    <td>
        <div class="cardview">
            <a href="{{route('laporan.pengeluaranBulanan')}}">
                <img src="{{ asset('image/pengeluaran.jpg') }}" style="width:100%" >
            </a>
        </div>
    </td>
    <td>
        <div class="cardview">
        <a href="{{route('laporan.stokTerlaris')}}">
            <img src="{{ asset('image/sparepartTerlaris.jpg') }}" style="width:100%">
        </a>
        </div>
    </td>
    </tr>
    <tr>
    <td>
        <div class="cardview">
        <a href="{{route('laporan.sisaStok')}}">
            <img src="{{ asset('image/sisaStok.jpg') }}" style="width:100%">
        </a>
        </div>
    </td>
    <td>
        <div class="cardview">
        <a href="{{route('laporan.jumlahService')}}">
            <img src="{{ asset('image/jumlahService.jpg') }}" style="width:100%">
        </a>
        </div>
    </td>
    <td>
        <div class="cardview">
        <a href="{{route('laporan.cabang')}}">
            <img src="{{ asset('image/laporanCabang.jpg') }}" style="width:100%">
        </a>
        </div>
    </td>
    </tr>
<table>
@endsection
