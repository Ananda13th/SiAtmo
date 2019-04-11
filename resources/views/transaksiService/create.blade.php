@extends('layouts.cs')

@section('content')
<br>
<h4 class="mt2">Tambah Transaksi Service </h4>
<hr>

@if ($errors->any())
    <div class="alert alert-danger pb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('transaksiService.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Kode Nota</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="kodeNota" name="kodeNota">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="namaKonsumen" name="namaKonsumen">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nomor Telpon Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="noTelpKonsumen" name="noTelpKonsumen">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Alamat Konsumen</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="alamatKonsumen" name="alamatKonsumen">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4">
            <a class="btn btn-primary" id="+sparepart"> Tambah Sparepart</a>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Detail Service</label>
    </div>
    <table class="table table-striped table-hover table-bordered" id="tb">
    <thead>
        <tr>
            <th>Jasa Service</th>
            <th>Biaya</th>
            <th>Plat Nomor</th>
            <th>Montir</th>
            <th> <button class="btn add-more" id="addMore" type="button">+</button> </th>
        </tr>
    </thead>
    <tbody>
    <div class="field_wrapper">
        <tr>
            <td>
                <select class="custom-select kodeService" name="kodeService[]">
                    <option value=""> --Pilih Jasa Service-- </option>";
                    @foreach($service as $s) {
                            <option value="{{ $s['kodeService'] }}" data-price="{{ $s->biayaService }}"> {{ $s['keterangan'] }} </option>";
                    }
                    @endforeach
                </select>
            </td> 
            <td> 
                <input class="form-control biayaServiceTransaksi" type="text" name="biayaServiceTransaksi[]" autocomplete="off" readonly> </td>
            <td>
                <select class="custom-select" id="platNomorKendaraan" name="platNomorKendaraan[]">
                    <option value=""> --Pilih Kendaraan-- </option>";
                    @foreach($konsumen as $k) {
                            <option value="{{ $k['platNomorKendaraan'] }}"> {{ $k['platNomorKendaraan'] }} </option>";
                    }
                    @endforeach
                </select>
            </td>
            <td>
                <select class="custom-select" id="emailPegawai" name="emailPegawai[]">
                    <option value=""> --Pilih Montir-- </option>";
                    @foreach($pegawai as $p) {
                        @if($p->idPosisi == 4)
                        {
                            <option value="{{ $p['email'] }}"> {{ $p['name'] }} </option>";
                        }
                        @endif
                    }
                    @endforeach
                </select>
            </td>
            <td> <button class="btn add-more" id="remove" type="button">x</button> </td>
        </tr>
    </tbody>
    </table>
    <br>
    <table class="table table-striped table-hover table-bordered" id="tb" style="visibility:hidden">
    <thead>
        <tr>
            <th>Sparepart</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th> <button class="btn add-more" id="addMore" type="button">+</button> </th>
        </tr>
    </thead>
    <tbody>
    <div class="field_wrapper">
        <tr>
            <td>
                <select class="custom-select" id="kodeSparepart" name="kodeSparepart[]">
                    <option value=""> --Pilih Sparepart-- </option>";
                    @foreach($sparepart as $s) {
                            <option value="{{ $s['kodeSparepart'] }}" data-price="{{ $s->hargaJual }}"> {{ $s['namaSparepart'] }} </option>";
                    }
                    @endforeach
                </select>
            </td> 
            <td> 
                <input class="form-control hargaJualTransaksi" type="text" name="hargaJualTransaksi[]" autocomplete="off" readonly> </td>
            </td>
            <td> <input type="number" id="jumlahSparepart" name="jumlahSparepart" step="1"> </td>
            <td> <button class="btn add-more" id="remove" type="button">x</button> </td>
        </tr>
    </tbody>
    </table>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
</form>
<script>
    $(function(){
        $('#addMore').on('click', function() {
                var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
                data.find("input").val('');
        });
        $(document).on('click', '#remove', function() {
            var trIndex = $(this).closest("tr").index();
                if(trIndex>=1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });    

    $(function() {
        $('body').on('change', '.kodeService', function(){
            var price = $(this).children('option:selected').data('price');
            $(this).closest('tr').find('.biayaServiceTransaksi').val(price);
        });
    });

    $(document).ready(function(){
        $("#+sparepart").click(function(){
            $("#tb").show();
        });
    }); 
</script>

@endsection
