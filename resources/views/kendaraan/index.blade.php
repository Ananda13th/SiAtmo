@extends('layouts.owner')

@section('content')

<h4 class="mt-2">Data Kendaraan</h4>
<hr>
<a class="btn btn-success" href="{{ route('kendaraan.create')}}"> <span class="oi oi-plus"></span> Tambah </a>

@if ($message = Session::get('success'))
<div class="alert alert-success mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif

@if ($message = Session::get('failed'))
<div class="alert alert-danger mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif
<br>
<br>
<form action="service/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="keterangan" id="namaKendaraan" onkeyup="search()"
            placeholder="Cari Kendaraan">
            <button type="submit" class="btn btn-default">
                <span class="oi oi-zoom-in"></span>
            </button>
        </span>
    </div>
</form>
<br>

<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Merk Kendaraan</th>
                <th>Tipe Kendaraan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kendaraan as $data)
            <tr>
                <td><?=++$no?></td>
                <td><?= $data->merkKendaraan?></td>
                <td><?= $data->tipeKendaraan ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('kendaraan.edit', $data['kodeKendaraan']) }}"> <i class="oi oi-pencil"></i> Edit</a>
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
					<p>Yakin ingin menhapus data kendaraan?</p>
				</div>
				<!-- footer modal -->
				<div class="modal-footer">
                    {{ Form::open(array('route' => array('kendaraan.destroy', $data['kodeKendaraan']), 'method' => 'DELETE')) }}
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
            input = document.getElementById("namaKendaraan");
            filter = input.value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
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