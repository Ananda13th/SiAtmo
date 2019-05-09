@extends('layouts.app')

@section('content')
<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered" id="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Merk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sparepart as $data)
            <tr>
                <td><?= $data->namaSparepart?></td>
                <td><?= $data->merkSparepart?></td>
                <td><?= $data->hargaJual ?></td>
                <td><?= $data->jumlahStok ?></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection