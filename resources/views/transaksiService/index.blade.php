@extends('layouts.cs')

@section('content')

<h4 class="mt-2">Data Transaksi Service</h4>
<hr>
<a class="btn btn-success" href="{{ route('transaksiService.create')}}"> <span class="oi oi-plus"></span> Tambah </a>

@if ($message = Session::get('success'))
<div class="alert alert-success mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif

<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Nota</th>
                <th>Tanggal Transaksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tService as $data)
                @if($data->statusTransaksi != "selesai")
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <!-- <td><?= $data['platNomorKendaraan']?></td>
                    <td><?= $data['keterangan']?></td>
                    <td><?= $data['statusTransaksi']?></td> -->
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('transaksiService.edit', $data['kodeNota']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                        <a class="btn btn-sm btn-primary" href="{{ route('transaksiService.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</button>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

@endsection