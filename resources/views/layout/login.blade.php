<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Sistem Monitoring Kesehatan Mental dan Prestasi Belajar</title>
</head>
<body>
<div class="fullpage">
    <div id="branding">
        <img src="{{url("/asset/bk.jpeg")}}" style="width: 100%; height: 790px;background-size: cover;">
    </div>
    <div id="contentWrap">
        <div class="content">
            <div class="header center" style="margin-bottom: 8px!important;">
            </div>

            @yield('form')

        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
