@extends('layouts.owner')

@section('content')

<h4 class="mt-2">Data Jasa Service</h4>
<hr>
<a class="btn btn-success" href="{{ route('service.create')}}"> <span class="oi oi-plus"></span> Tambah </a>
<br>
<br>
<form action="service/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="keterangan"
            placeholder="Cari Jasa Service">
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
                <th>Kode Service</th>
                <th>Keterangan</th>
                <th>Biaya</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($service as $data)
            <tr>
                <td><?= $data->kodeService?></td>
                <td><?= $data->keterangan ?></td>
                <td><?= $data->biayaService?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('service.edit', $data['kodeService']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal"><span class="oi oi-trash"></span> Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<h4 class="modal-title">PERINGATAN</h4>
				</div>
				<!-- body modal -->
				<div class="modal-body">
					<p>Yakin ingin menhapus jasa service?</p>
				</div>
				<!-- footer modal -->
				<div class="modal-footer">
                    {{ Form::open(array('route' => array('service.destroy', $data['kodeService']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Ya</button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    {{ Form::close() }}
					
				</div>
			</div>
		</div>
	</div>
</div>

@endsection