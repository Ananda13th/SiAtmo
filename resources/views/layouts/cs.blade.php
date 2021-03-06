<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SiAtmo</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" >
            function preventBack(){window.history.forward();}
                setTimeout("preventBack()", 0);
                window.onunload=function(){null};
        </script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/iconic-bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha256-m/h/cUDAhf6/iBRixTbuc8+Rg2cIETQtPcH9D3p2Kg0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" />
</head>
<body class="h-100">
<nav class="navbar navbar-expand-sm navbar-dark sticky-top bg-info">
    <a class="navbar-brand" href="#">Menu Transaksi</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toogle navigation">
        <span class=navbar-toggler-icon></span>
    </button>
    <nav class="collapse navbar-collapse" id="sidebar">
    <ul class="navbar-nav d-sm-none">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('home')}}">
                <i class="oi oi-dashboard"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('daftarKendaraanKonsumen')}}">
            <i class="oi oi-key"></i> Daftar Kendaraan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('transaksiSparepart.index')}}">
            <i class="oi oi-cog"></i> Sparepart
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('transaksiService.index')}}">
            <i class="oi oi-cog"></i> Service
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('transaksiFull.index')}}">
            <i class="oi oi-cog"></i> Full
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="oi oi-account-logout"></i> Logout
            </a>
        </li>
    </ul>
    </nav>
</nav>

<div class="container-fluid h-100">
    <div class="row h-100">
        <nav class="col-md-2 col-sm-3 bg-dark h-100 p-0 position-fixed d-none d-sm-block">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{ route('home')}}">
                        <i class="oi oi-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{route('daftarKendaraanKonsumen')}}">
                    <i class="oi oi-key"></i> Daftar Kendaraan
                    </a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{route('transaksiSparepart.index')}}">
                    <i class="oi oi-cog"></i></span> Sparepart
                    </a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{route('transaksiService.index')}}">
                    <i class="oi oi-cog"></i> Service
                    </a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{route('transaksiFull.index')}}">
                    <i class="oi oi-cog"></i> Full
                    </a>
                </li>
                <li class="list-group-item bg-dark">
                    <a class="nav-link text-white" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="oi oi-account-logout"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <div class="col-md-10 col-sm-9 offset-md-2 offset-sm-3 mb-3">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <section>
                @yield('content')
            </section>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>


