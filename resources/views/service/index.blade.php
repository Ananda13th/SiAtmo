@extends('layouts.owner')

@section('content')
<meta name="_token" content="{{ csrf_token() }}">
<h4 class="mt-2">Data Jasa Service</h4>
<hr>
<a class="btn btn-success" href="{{ route('service.create')}}"> <span class="oi oi-plus"></span> Tambah </a>
<br>
<br>
<form action="service/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="keterangan" id="namaService" onkeyup="search()"
            placeholder="Cari Jasa Service">
            <button type="submit" class="btn btn-default">
                <span class="oi oi-zoom-in"></span>
            </button>
        </span>
    </div>
</form>
<!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" /> -->
@if ($message = Session::get('success'))
<div class="alert alert-success mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif

@if ($message = Session::get('failed'))
<div class="alert alert-failed mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif

<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered" id="table">
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
                    {{ Form::open(array('route' => array('service.destroy', $data['kodeService']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Hapus </button>
                        <a class="btn btn-sm btn-info" href="{{ route('service.edit', $data['kodeService']) }}"> <i class="oi oi-pencil"></i> Edit</a>
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
 function search() {
            var input, sfilter, table, tr, td, i, txtValue;
            input = document.getElementById("namaService");
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