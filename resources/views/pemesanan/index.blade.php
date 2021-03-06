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
                @if($data->statusPemesanan == "On Process")
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['namaPerusahaan']?></td>
                    <td><?= $data->tanggalPemesanan ?></td>
                    <td><?= $data->statusPemesanan ?></td>
                    <td>
                    {{ Form::open(array('route' => array('pemesanan.destroy', $data['noPemesanan']), 'method' => 'DELETE')) }}
                        <button class="btn btn-sm btn-danger" type="submit"> <i class="oi oi-trash" data-target="#myModal"></i> Hapus</button>
                        <a class="btn btn-sm btn-info" href="{{ route('pemesanan.edit', $data['noPemesanan']) }}"><span class="oi oi-pencil"></span> Edit</a>
                        <a class="btn btn-sm btn-primary" href="{{ route('pemesanan.downloadPDF', $data['noPemesanan']) }}"><span class="oi oi-eye"></span> Lihat</a>
                        <a class="btn btn-sm btn-success" href="{{ route('pemesanan. printPreview', $data['noPemesanan']) }}"><span class="oi oi-print"></span> Cetak</a>
                    {{ Form::close() }}
                    </td>
                </tr>
                @elseif($data->statusPemesanan == "Shipping")
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['namaPerusahaan']?></td>
                    <td><?= $data->tanggalPemesanan ?></td>
                    <td><?= $data->statusPemesanan ?></td>
                    <td>
                    {{ Form::open(array('route' => array('pemesanan.selesaiOrder', $data['noPemesanan']), 'method' => 'PATCH')) }}
                        <button type="submit" class="btn btn-sm btn-success"> <i class="oi oi-circle-check"></i> Sampai </button>
                    {{ Form::close() }}
                    </td>
                </tr>
                @else
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['namaPerusahaan']?></td>
                    <td><?= $data->tanggalPemesanan ?></td>
                    <td><?= $data->statusPemesanan ?></td>
                    <td></td>
                </tr>
                @endif
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
                    <!-- Nama Perusahaan           : {{$data->namaPerusahaan}} <br>
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
                    </table> -->
				<div class="modal-footer">
                    {{ Form::open(array('route' => array('pemesanan.destroy', 'noPemesanan'=>'noPemesanan'), 'method' => 'DELETE')) }}
                        <button type="submit" href="route('pemesanan.destroy', )" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Ya</button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection