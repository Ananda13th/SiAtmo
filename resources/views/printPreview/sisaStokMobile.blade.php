<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Sisa Stok</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
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
        font-size: 30;
        text-transform: uppercase;
      }
    </style>
  </head>
  <h1> <img src="{{ asset('image/Logo2.PNG') }}" width=700> </h1>
  <body>
  <div class="default-list-upper-alpha">
      <div>
      <div class="label">
        <label>Laporan Sisa Stok </label>
      </div>
      <br>
      <label>Tahun : {{$tahun}}</label>
      <br>
      <label>Tipe : {{$tipe}}</label>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{ $d->Bulan }}</td>
                        <td>{{ $d->SisaStok }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <br>
    <div class="row">
       <div class="col-md-10 col-md-offset-1">
           <div class="panel panel-default">
               <div class="panel-body">
                   <div id="piechart" class="pie-chart"></div>
               </div>
           </div>
       </div>
      <input type="button" value="Print" class="btn no-print" onclick="PrintDoc()"/>
    </div>
  </body>
  <script>
      function PrintDoc() {
        window.print();
      }
      
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: bulan,
              datasets: [{
                  label: 'Nilai Pendapatan',
                  data: pendapatan,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });
  </script>
</html>