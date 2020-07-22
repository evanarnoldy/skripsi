<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{url('css/dashboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('fontawesome-free-5.12.1-web/css/all.min.css')}}">

    <title>Sistem Monitoring Kesehatan Mental dan Prestasi Belajar</title>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-drk border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Monitoring Kesehatan Mental dan Prestasi Belajar</div>
        <div class="list-group list-group-flush">
            <a href="{{ route('guru') }}" class="{{set_active('guru')}}list-group-item bg-list list-group-item-action"><i class="fas fa-home mr-15"></i> Dashboard</a>
            <a href="{{ route('daftar-pertanyaan-guru') }}" class="{{set_active('daftar-pertanyaan-guru')}}list-group-item bg-list list-group-item-action"><i class="fas fa-list mr-15"></i>Daftar Pertanyaan</a>
            <a href="{{ route('korelasi') }}" class="{{set_active('korelasi')}}list-group-item bg-list list-group-item-action"><i class="far fa-chart-bar mr-15"></i>Hitung Korelasi</a>
            <a href="#pageSubmenuu" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-list dropdown-togglee"><i class="fas fa-poll mr-15"></i>Hasil</a>
            <ul class="collapse list-unstyled" id="pageSubmenuu">
                <li>
                    <a href="{{ route('survey-guru') }}" class="{{set_active('survey-guru')}}list-group-item bg-list list-group-item-action">Hasil Monitoring Kesehatan Mental</a>
                </li>
                <li>
                    <a href="{{ route('guru.prestasi') }}" class="{{set_active('guru.prestasi')}}list-group-item bg-list list-group-item-action">Hasil Prestasi Belajar</a>
                </li>
                <li>
                    <a href="{{ route('korelasi-guru') }}" class="{{set_active('korelasi-guru')}}list-group-item bg-list list-group-item-action">Hasil Korelasi Sekolah</a>
                </li>
            </ul>
            <a href="{{ route('daftar.keluhanguru') }}" class="{{set_active('daftar.keluhanguru')}}list-group-item bg-list list-group-item-action"><i class="fas fa-comments mr-15"></i>Daftar Keluhan</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand bg-gl p-0 shadow">
            <div class="nav toggle">
                <a id="menu-toggle"><i class="fas fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav ml-auto" style="margin: 13px">
                <li class="dropdown">
                    <a href="#" class="nama-ses mt-14 dropdown-togglee" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-globe"></i>Notifikasi<span class="badge badge-danger notif">{{count(auth()->user()->unreadNotifications)}}</span>
                    </a>
                    <ul class="dropdown-menu cus" aria-labelledby="navbarDropdown">
                        <li>
                            @forelse(auth()->user()->unreadNotifications as $notif)
                                @include('layout.notification.'.Str::snake(class_basename($notif->type)).'.guru')
                                {{$notif->markAsRead()}}
                            @empty
                                <span>Tidak ada pesan</span>
                            @endforelse
                        </li>
                    </ul>
                </li>
                <li class="dropdown" style="padding-left: 15px;">
                    <a href="#" class="user-profile dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{url('uploads/avatar/'.auth()->user()->avatar)}}" class="rounded-circle pt-7 pb-7" style="width: 60px; height: 74px">
                        <span>{{Auth::user()->nama}}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="left: -30px">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt mr-15"></i>Logout</a>
                            <a class="dropdown-item" href="{{ route('profil-guru') }}"><i class="fas fa-user mr-15"></i>Profil</a>
                            <a class="dropdown-item" href="{{ route('psswrd-guru') }}"><i class="fas fa-key mr-15"></i>Ganti Password</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        @yield('container')
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="{{'/js/app.js'}}"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

</script>
@yield('footer')
</body>
</html>
