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

    <title>Sistem Monitoring Kesehatan Mental</title>
</head>
<body>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Monitoring Kesehatan Mental</div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin') }}" class="{{set_active('admin')}}list-group-item list-group-item-action bg-puteh"><i class="fas fa-home mr-15"></i> Dashboard</a>
            <a href="#" class="list-group-item list-group-item-action bg-puteh">Overview</a>
            <a href="#" class="list-group-item list-group-item-action bg-puteh">Events</a>
            <a href="#" class="list-group-item list-group-item-action bg-puteh">Profile</a>
            <a href="#" class="list-group-item list-group-item-action bg-puteh">Status</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-dark bg-light flex-md-nowrap p-0 shadow">
            <button class="btn btn-primary ml-20" id="menu-toggle">Buka Menu</button>

            <div class="navbar-nav px-3">
                <div class="row mr-50">
                    <div class="nav-item col mr-18">
                        <div class="nama-ses mt-14">Notifikasi</div>
                    </div>
                    <div class="nav-item col">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown"><img src="{{url('asset/yoyo.jpg')}}" class="rounded-circle pt-7 pb-7" style="width: 60px; height: 74px"></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                    <div class="nav-item col">
                        <div class="nama-ses mt-14" style="margin-left: -20px"></div>
{{--                        {{Auth::user()->nama}}--}}
                    </div>
                </div>
            </div>
        </nav>

        @yield('container')

    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

</script>
</body>
</html>
