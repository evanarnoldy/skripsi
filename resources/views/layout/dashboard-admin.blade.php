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
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-list dropdown-togglee"><i class="fas fa-users mr-15"></i>Data User</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="{{ route('data-siswa') }}" class="{{set_active('data-siswa')}}list-group-item bg-list list-group-item-action">Data siswa</a>
                </li>
                <li>
                    <a href="{{ route('data-guru') }}" class="{{set_active('data-guru')}}list-group-item bg-list list-group-item-action">Data guru</a>
                </li>
                <li>
                    <a href="{{ route('data-wali') }}" class="{{set_active('data-wali')}}list-group-item bg-list list-group-item-action">Data walikelas</a>
                </li>
            </ul>
            <a href="{{ route('daftar.prestasi') }}" class="{{set_active('daftar.prestasi')}}list-group-item bg-list list-group-item-action"><i class="fas fa-book mr-15"></i>Prestasi Belajar</a>
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
                <li class="dropdown" style="padding-left: 15px;">
                    <a href="#" class="user-profile dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{url('uploads/avatar/'.auth()->user()->avatar)}}" class="rounded-circle pt-7 pb-7" style="width: 60px; height: 74px">
                        <span>{{Auth::user()->nama}}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="left: -30px">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt mr-15"></i>Logout</a>
                            <a class="dropdown-item" href="{{ route('profil.admin') }}"><i class="fas fa-user mr-15"></i>Profil</a>
                            <a class="dropdown-item" href="{{ route('psswrd.admin') }}"><i class="fas fa-key mr-15"></i>Ganti Password</a>
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

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

</script>
@yield('footer')
</body>
</html>
