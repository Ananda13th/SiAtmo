@extends('layouts.owner')

@section('content')

<h4 class="mt-2">Data Sparepart</h4>
<hr>
<a class="btn btn-success" href="{{ route('sparepart.create')}}"> <span class="oi oi-plus"></span> Tambah </a>
<a class="btn btn-success" href="{{ route('pemesanan.index')}}"> <span class="oi oi-eye"></span> Pemesanan </a>
<br>
<br>
<form action="sparepart/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="namaSparepart"
            placeholder="Cari sparepart"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="oi oi-zoom-in"></span>
            </button>
        </span>
    </div>
</form>
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
                <th>Gambar</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Merk</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Jumlah Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sparepart as $data)
            <tr>
                <td><?=++$no?></td>
                <td><img src="{{ asset('image/'.$data['gambarSparepart'])}}" width="100"></td>
                <!-- <td><img src="$data->gambarSparepart/jpeg;base64,'.base64_encode($data->gambarSparepart) .'"></td> -->
                <td><?= $data->kodeSparepart?></td>
                <td><?= $data->namaSparepart ?></td>
                <td><?= $data->tipeSparepart?></td>
                <td><?= $data->merkSparepart?></td>
                <td><?= $data->hargaJual?></td>
                <td><?= $data->hargaBeli?></td>
                <td><?= $data->jumlahStok?></td>
                <td>
                    {{ Form::open(array('route' => array('sparepart.destroy', $data['kodeSparepart']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Hapus </button>
                        <a class="btn btn-sm btn-info" href="{{ route('sparepart.edit', $data['kodeSparepart']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                    {{ Form::close() }}
                    <!-- <a class="btn btn-sm btn-info" href="{{ route('sparepart.edit', $data['kodeSparepart']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal"><span class="oi oi-trash"></span> Hapus</button> -->
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
					<h4 class="modal-title">PERINGATAN</h4>
				</div>
				<div class="modal-body">
					<p>Yakin ingin menghapus sparepart?</p>
                    <p>{{$data['kodeSparepart']}}</p>
				</div>
				<div class="modal-footer">
                    {{ Form::open(array('route' => array('sparepart.destroy', $data['kodeSparepart']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Ya</button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection