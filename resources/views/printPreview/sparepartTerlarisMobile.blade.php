<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Pengeluaran Bulanan</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
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

      img {
        width : 100%;
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

      div.label {
        text-align: center;
        font-weight: bold;
        font-size: 30px;
      }
    </style>
  </head>
  <h1> <img  src="{{ asset('image/Logo2.PNG') }}" width=700> </h1>
  <body>
  <div class="default-list-upper-alpha">
      <div>
      <div class="label">
        <label>Laporan Sparepart Terlaris</label>
      </div>
      <br>
      <label>Tahun : {{$tahun}}</label>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Sparepart</th>
                    <th>Pembelian</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
              @foreach($data as $d)
                <tr>
                  <td>{{$d->Bulan}}</td>
                  <td>{{$d->NamaBarang}} </td>
                  <td>{{$d->TipeBarang}} </td>
                  <td>{{$d->JumlahPenjualan}} </td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
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