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
      .text-right-c{
        text-align: right;
        margin-right: 50px;
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
        text-align: center;
      }

      table {
        border-collapse: collapse;
        width: 100%;
      }

      th {
        height: 10px;
      }
      hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0;
      }
    </style>
  </head>
  <?php $image_path = '/image/Logo2.PNG'; ?>
  <h1> <img src="{{ public_path().$image_path }}" width=700> </h1>
  <body>
  <div class="default-list-upper-alpha">
      <div class="text-right"> {{$data->tanggalTransaksi}} </div>
      {{$data->kodeNota}} <br>
      <p> Cust          : {{$data->namaKonsumen}}  <span> <div class="text-right"> CS : {{$pegawai->name}} </div> </span> </p>    
      <br>
      Nomor Telepon : {{$data->noTelpKonsumen}}   
      <hr/>
      <div class="text-center">Sparepart</div> :
      <hr/>
      <div>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama </th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{$d->kodeSparepart}} </td>
                        <td>{{$d->namaSparepart}} </td>
                        <td>{{$d->jumlahSparepart}} </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td>Subtotal</td>
                    <td>{{$d->subtotal}} </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diskon</td>
                    <td>{{$d->diskon}} </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td>{{$d->total}} </td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </body>
</html>