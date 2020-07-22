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
<div class="page-wrapper p-t-100 p-b-100 font-robo" style="background-image:url({{"/asset/buku.jpg"}});background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <div class="wrapper wrapper--w680">
        <div class="card tengah" style="width:40rem">
            <div class="card-heading">
            </div>
            <div class="card-body">
                <h2 class="title">@yield('title')</h2>
                @yield('form')
            </div>
        </div>
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
