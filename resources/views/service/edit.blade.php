@extends('layouts.owner')

@section('content')
<br>
<h4 class="mt2">Edit Jasa Service</h4>
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

{{ Form::model($service, ['method' => 'PATCH', 'route'=>['service.update', $service->kodeService]]) }}
    @csrf
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Keterangan</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="keterangan" name="keterangan" value="{{$service['keterangan']}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2" col-form-label>Biaya Service</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" id="biayaService" name="biayaService" value="{{$service['biayaService']}}">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-sm btn-danger"><i class="oi oi-trash"></i> Simpan</button>
    <button type="reset" class="btn btn-sm btn-warning"><i class="oi oi-circle-x"></i> Batal</button>
     {{ Form::close() }}
@endsection
