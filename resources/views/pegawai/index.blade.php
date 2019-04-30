@extends('layouts.owner')

@section('content')

<h4 class="mt-2">Data Pegawai</h4>
<hr>
<a class="btn btn-success" href="{{ route('pegawai.create')}}"> <span class="oi oi-plus"></span> Tambah </a>
<br>
<br>
<form action="pegawai/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="name" id="namaPegawai"
            placeholder="Cari pegawai" onkeyup="search()"> <span class="input-group-btn">
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
    <table class="table table-striped table-hover table-bordered" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Posisi</th>
                <th>Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $data)
                @if($data->idPosisi !=1)
                <tr>
                    <td><?=++$no?></td>
                    <td><?= $data['name']?></td>
                    <td><?= $data['email'] ?></td>
                    <td><?= $data['keteranganPosisi']?></td>
                    <td><?= $data['gaji']?></td>
                    <td>
                        {{ Form::open(array('route' => array('pegawai.destroy', $data['email']), 'method' => 'DELETE')) }}
                            <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Hapus </button>
                            <a class="btn btn-sm btn-info" href="{{ route('pegawai.edit', $data['email']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                        {{ Form::close() }}
                        <!-- <a class="btn btn-sm btn-info" href="{{ route('pegawai.edit', $data['email']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal"><span class="oi oi-trash"></span> Hapus</button> -->
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">PERINGATAN</h4>
				</div>
				<div class="modal-body">
					<p>Yakin ingin menghapus pegawai?</p>
                    <p>{{$data['email']}}</p>
				</div>
				<div class="modal-footer">
                    {{ Form::open(array('route' => array('pegawai.destroy', $data['email']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Ya</button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>

<script>
 function search() {
            var input, sfilter, table, tr, td, i, txtValue;
            input = document.getElementById("namaPegawai");
            filter = input.value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } 
                    else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
</script>
@endsection