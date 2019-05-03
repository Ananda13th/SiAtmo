@extends('layouts.owner')

@section('content')
<br>
<h4 class="mt2">Tambah Pemesanan </h4>
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

{{ Form::model($pemesanan, ['method' => 'PATCH', 'route'=>['pemesanan.update', $pemesanan->noPemesanan ]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>No Pemesanan</label>
        <input class="col-sm-3" type="text" value="{{ $pemesanan->noPemesanan }}" name=noPemesanan readonly>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Nama Perusahaan</label>
        <input class="col-sm-3" type="text" value="{{ $pemesanan->namaPerusahaan }}" readonly>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Detail Pemesanan</label>
    </div>
    <table class="table table-striped table-hover table-bordered" id="tb">
    <thead>
        <tr>
            <th>Sparepart</th>
            <th>Jumlah</th>
            <th> <button class="btn add-more" id="addMore" type="button">+</button> </th>
        </tr>
    </thead>
    <tbody>
    <div class="field_wrapper">
        @foreach($detil as $d)
            <tr>
                <td> <input class="form-control" type="text" value="{{$d->namaSparepart}}">  </td>
                <td> <input class="form-control" type="number" value="{{$d->jumlahPemesanan}}">  </td>
                <td> <input class="form-control" type="text" value="{{$d->satuan}}"> </td>
            </tr>
        @endforeach
        <tr>
            <td>
                <select class="custom-select" id="kodeSparepart" name="kodeSparepart[]">
                    <option value=""> --Pilih Sparepart-- </option>";
                    @foreach($sparepart as $s) {
                            <option value="{{ $s['kodeSparepart'] }}" data-price="{{ $s->hargaBeli }}"> {{ $s['namaSparepart'] }} </option>";
                    }
                    @endforeach
                </select>
            </td> 
            <td> <input type="number" id="jumlahPemesanan" name="jumlahPemesanan[]" step="1"> </td>
            <td>
            <select class="custom-select" id="satuan" name="satuan[]">
                <option value="buah"> Buah </option>";
                <option value="dus"> Dus </option>";
            </select>
            </td>
            <td> <button class="btn add-more" id="remove" type="button">x</button> </td>
        </tr>
    </tbody>
    </table>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
    {{ Form::close() }}
    <script>
    $(function(){
        $('#addMore').on('click', function() {
                var data = $("#tb tr:eq(2)").clone(true).appendTo("#tb");
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
        $('#kodeService').on('change', function(){
            var price = $(this).children('option:selected').data('price');
            $('#biayaServiceTransaksi').val(price);
        });
    });

    $(document).ready(function(){
        $("#+sparepart").click(function(){
            $("#tb").show();
        });
    }); 
</script>
@endsection
