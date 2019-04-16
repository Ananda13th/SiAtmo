<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Pemesanan</title>
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css"> -->
    <style type="text/css" media="all">
      .text-center {text-align: center;}
      .text-right {
        text-align: right;
        margin-right: 30px;
      }
			.fw600 {font-weight: 600;}
			.mb8 {margin-bottom: 8px;}
			.default-list-upper-alpha {
				list-style-type: upper-alpha;
				list-style-position: inside;
				margin-left: 8px;
        margin-right: 30px;
			}	
      table, td, th {
        border: 1px solid black;
      }

      table {
        border-collapse: collapse;
        width: 100%;
      }

      th {
        height: 10px;
      }
    </style>
  </head>
  <?php $image_path = '/image/Logo2.PNG'; ?>
  <h1> <img src="{{ public_path().$image_path }}" width=700> </h1>
  <body>
  <div class="default-list-upper-alpha">
      <div class="text-right"> {{$data->tanggalPemesanan}} </div>
      Kepada Yth. <br>
      {{$data->namaPerusahaan}}                                   
      <br>
      @foreach($supplier as $s)
        @if($s->namaPerusahaan == $data->namaPerusahaan)
        <label>{{$s->alamatSupplier}} </label> <br>
        @endif
      @endforeach
      <br>
      Mohon Untuk Disediakan barang-barang berikut : <br>
      <div>
        <table>
            <thead>
                <tr>
                    <th>Kode Sparepart</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detil as $d)
                    @if($d->noPemesanan == $data->noPemesanan)
                    <tr>
                        <td>{{$d->kodeSparepart}} </td>
                        <td> {{$d->jumlahPemesanan}} </td>
                        <td> {{$d->satuan}} </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="text-right"> Owner </div>
    </div>
  </body>
</html>