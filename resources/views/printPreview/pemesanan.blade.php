<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Pemesanan</title>
    <link href="/css/print.css" rel="stylesheet" media="print" type="text/css">
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
      .table-supplier {
        text-align: left;
        border: 1;
        width: 50%;
        border-collapse: collapse;
      }	
      .table-supplier td{
        text-align: left;
        border: 0;
      }	
      .table-detail, td, th {
        border: 1px solid black;
        text-align: center;
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
      <div class="text-right"> No : {{$data->noPemesanan}} </div>
      <div class="text-right"> {{$data->tanggalPemesanan}} </div>
      <table class="table-supplier">
        <tr>
          <td> Kepada Yth. </td>
        </tr>
        <tr>
          <td> {{$data->namaPerusahaan}} </td>
        </tr>
        <tr>
          <td>
          @foreach($supplier as $s)
            @if($s->namaPerusahaan == $data->namaPerusahaan)
            <label>{{$s->alamatSupplier}} </label>
            @endif
          @endforeach
          </td>
        </tr>
      </table>
      <br>
      Mohon Untuk Disediakan barang-barang berikut : <br>
      <div>
        <table class="table-detail">
            <thead>
                <tr>
                    <th>Nama Sparepart</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detil as $d)
                    @if($d->noPemesanan == $data->noPemesanan)
                    <tr>
                        <td>{{$d->namaSparepart}} </td>
                        <td>{{$d->merkSparepart}} </td>
                        <td>{{$d->tipeSparepart}} </td>
                        <td>{{$d->jumlahPemesanan}} </td>
                        <td>{{$d->satuan}} </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
      </div>
      <br>
      <br>
      <div class="text-right"> Hormat Kami,  </div>
      <br>
      <br>
      <br>
      <br>
      <div class="text-right-c"> Owner </div>
      <br>
      <input type="button" value="Print" class="btn" onclick="PrintDoc()"/>
    </div>
  </body>
  <script type="text/javascript">
      function PrintDoc() {

        window.print();
      }
  </script>
</html>