@extends('layouts.owner')

@section('content')

<h4 class="mt-2">Data Pemesanan</h4>
<hr>
<a class="btn btn-success" href="{{ route('pemesanan.create')}}"> <span class="oi oi-plus"></span> Tambah </a>

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
                <th>Nama Perusahaan</th>
                <th>Tanggal Pemesanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanan as $data)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['namaPerusahaan']?></td>
                    <td><?= $data->tanggalPemesanan ?></td>
                    <td><?= $data->statusPemesanan ?></td>
                    <td>
                    <a class="btn btn-sm btn-info" href="{{ route('pemesanan.edit', $data['noPemesanan']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal"><span class="oi oi-eye"></span> Lihat</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Data Pemesanan</h4>
				</div>
				<div class="modal-body">
                    Nama Perusahaan           : {{$data->namaPerusahaan}} <br>
                    Tanggal Pemesanan         : {{$data->tanggalPemesanan}} <br>
                    Status                    : {{$data->statusPemesanan}} <br>
                    Detail Pemesanan : <br>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Sparepart</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
</div>

@endsection