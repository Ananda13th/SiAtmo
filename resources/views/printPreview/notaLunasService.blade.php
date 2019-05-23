<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Nota Lunas</title>
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
      .table-invisible {
        border: 0;
      }
      td.invisible {
        border: none;
      }
      .text-left{
        text-align: left;
        margin-left: 50px;
      }
      img{
        width:100%;
      }
      @media print{
        #pager,
        form,
        .no-print{
          display : none !important;
          height : 0;
        }
      }

      @page {
        margin:0;
      }
    </style>
  </head>
  <h1> <img  src="{{ asset('image/Logo2.PNG') }}" width=700> </h1>
  <body>
  <div class="default-list-upper-alpha">
  <table class=table-invisible>
      <tr>
        <td class="invisible"></td>
        <td class="invisible"> <div class="text-right">{{$data->tanggalTransaksi}} </div> </td>
      </tr>
      <tr>
        <td class="invisible"> <div class="text-left"> {{$data->kodeNota}} </div> </td>
      </tr>
      <tr>
        <td class="invisible"> <div class="text-left"> Cust    : {{$data->namaKonsumen}} </div> </td>
        <td class="invisible"> <div class="text-right"> CS      : {{$pegawai->name}} </div> </td> 
      </tr>
      <tr>
        <td class="invisible">   <div class="text-left">Nomor Telepon : {{$data->noTelpKonsumen}}  </div>  </td>
      </tr>
  </table>
      <hr/>
      <div>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama </th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detil as $d)
                @if($d->kodeNota == $data->kodeNota)
                    <tr>
                        <td>{{$d->kodeService}} </td>
                        <td>{{$d->keterangan}} </td>
                        <td>{{$d->biayaServiceTransaksi}} </td>
                    </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td>{{$data->subtotal}} </td>
                </tr>
                <tr>
                    <td colspan="2">Diskon</td>
                    <td>{{$data->diskon}} </td>
                </tr>
                <tr>
                    <td colspan="2">Total</td>
                    <td>{{$data->total}} </td>
                </tr>
            </tbody>
        </table>
      </div>
      <br>
      <input type="button" value="Print" class="btn no-print" onclick="PrintDoc()"/>
    </div>
  </body>
  <script type="text/javascript">
      function PrintDoc() {

        window.print();
      }
  </script>
</html>