@extends('layouts.app')

@section('content')

<div class="form-group row">
    <label class="col-sm-2" col-form-label>Nomor Telpon</label>
    <div class="col-sm-4">
        <input class="form-control" type="text" id="NomorTelpon" onkeyup="search()">
    </div>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered" id="table">
        <thead>
            <tr>
                <th>Kode Nota</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Kosumen </th>
                <th>Nomor Telpon </th>
                <th>Status Transaksi</th>
                <th>Plat Nomor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $data)
            <tr>
                <td><?= $data->kodeNota?></td>
                <td><?= $data->tanggalTransaksi?></td>
                <td><?= $data->namaKonsumen ?></td>
                <td><?= $data->noTelpKonsumen ?></td>
                <td><?= $data->statusTransaksi ?></td>
                <td><?= $data->platNomorKendaraan ?></td>
                <td><a data-item="{{ $data }}" class="btn btn-block details-button" data-toggle="modal" data-target="#modalDetail" id="detailButton">Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body edit-content">
                <label class="text-center" id="kodeNota">
            </div>
        </div>
    </div>
</div>

<script>
    function search() {
        var input, sfilter, table, tr, td, i, txtValue;
        input = document.getElementById("NomorTelpon");
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

    $(document).on('click', '#detailButton', function (e) {
      e.preventDefault();
      var item = $(this).data('item');
      $('#modalDetail #kodeNota').text(item.kodeNota);
    });
</script>
@endsection