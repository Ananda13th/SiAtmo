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
        <input type="text" class="form-control" name="namaSparepart" id="namaSparepart"
            placeholder="Cari sparepart" onkeyup="search()"> <span class="input-group-btn">
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

@if ($message = Session::get('failed'))
<div class="alert alert-success mt-3 pb-0">
    <p>{{ $message }}</p>
</div>
@endif
<br>
<a class="btn btn-primary" href="{{ route('sparepart.byStok')}}"> <span class="oi oi-eye"></span> Stok </a>
<a class="btn btn-primary" href="{{ route('sparepart.byHarga')}}"> <span class="oi oi-eye"></span> Harga </a>
<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered" id="table">
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
                <!-- <td><img src="data:image/JPG;base64,'.base64_encode($data['gambarSparepart']).'"/></td> -->
                <td><img src="{{ asset('image/'.$data['gambarSparepart'])}}" width="100"></td>
                <td><?= $data->kodeSparepart?></td>
                <td><?= $data->namaSparepart ?></td>
                <td><?= $data->tipeSparepart?></td>
                <td><?= $data->merkSparepart?></td>
                <td><?= $data->hargaJual?></td>
                <td><?= $data->hargaBeli?></td>
                <td><?= $data->jumlahStok?></td>
                <td width="20%">
                    {{ Form::open(array('route' => array('sparepart.destroy', $data['kodeSparepart']), 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-sm btn-danger"><span class="oi oi-trash"></span> Hapus </button>
                        <a class="btn btn-sm btn-info" href="{{ route('sparepart.edit', $data['kodeSparepart']) }}"> <i class="oi oi-pencil"></i> Edit</a>
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
            input = document.getElementById("namaSparepart");
            filter = input.value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
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