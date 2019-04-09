@extends('layouts.owner')

@section('content')
<br>
<h4 class="mt2">Tambah Jasa Service </h4>
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

<form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Keterangan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="keterangan" name="keterangan">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Biaya Service</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="biayaService" name="biayaService">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-info"><i class="oi oi-task"></i> Simpan</button>
    <button type="reset" class="btn btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
</form>
@endsection
