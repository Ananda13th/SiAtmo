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
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksiService as $data)
                @if($data->statusTransaksi != "Selesai")
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td><?= $data->total ?></td>
                    <td><?= $data->statusTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('dataTransaksi.edit', $data['kodeNota']) }}"><span class="oi oi-pencil"></span> Proses</a>
                    <a class="btn btn-sm btn-info" href="{{ route('transaksiService.downloadPDFLunas', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</a>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiService.printPreview', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</a>
                    </td>
                @else
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td><?= $data->total ?></td>
                    <td><?= $data->statusTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-info" href="{{ route('transaksiService.downloadPDFLunas', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</a>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiService.printPreview', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</a>
                @endif
                </tr>
            @endforeach
            @foreach($transaksiSparepart as $data)
                @if($data->statusTransaksi != "Selesai")
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td><?= $data->total ?></td>
                    <td><?= $data->statusTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('dataTransaksi.edit', $data['kodeNota']) }}"><span class="oi oi-pencil"></span> Proses</a>
                    <a class="btn btn-sm btn-info" href="{{ route('transaksiSparepart.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</a>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiSparepart.printPreview', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</a>
                    </td>
                @else
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td><?= $data->total ?></td>
                    <td><?= $data->statusTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-info" href="{{ route('transaksiSparepart.downloadPDF', $data['kodeNota']) }}"><span class="oi oi-eye"></span> Lihat</a>
                    <a class="btn btn-sm btn-success" href="{{ route('transaksiSparepart.printPreview', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</a>
                    </td>
                @endif
                </tr>
            @endforeach
            @foreach($transaksiFull as $data)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['kodeNota']?></td>
                    <td><?= $data->tanggalTransaksi ?></td>
                    <td><?= $data->total ?></td>
                    <td><?= $data->statusTransaksi ?></td>
                    <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('dataTransaksi.edit', $data['kodeNota']) }}"><span class="oi oi-pencil"></span> Proses</a>

                    <a class="btn btn-sm btn-success" href="{{ route('SPKFull.printPreview', $data['kodeNota']) }}"><span class="oi oi-print"></span> Cetak</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection