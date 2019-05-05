@extends('layouts.kasir')

@section('content')

<h4 class="mt-2">Data Transaksi</h4>
<hr>

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
            @foreach($transaksiService as $data)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('transaksiService.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</button>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiService.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</button>
                    </td>
                </tr>
            @endforeach
            @foreach($transaksiSparepart as $data)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('transaksiSparepart.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</button>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiSparepart.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</button>
                    </td>
                </tr>
            @endforeach
            @foreach($transaksiFull as $data)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('transaksiFull.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</button>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiFull.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection