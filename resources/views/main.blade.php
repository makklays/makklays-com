<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8" lang="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Development Makklays</title>

    <meta name="description" content="Makklays" />
    <meta name="keywords" content="Makklays" />
    <meta name="author" content="Makklays" />

    <meta property="og:title" content="Makklays" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://makklays.com" />
    <meta property="og:image" content="https://makklays.com/img/dog.jpg" />

    <link rel="shortcut icon" href="<?=config('app.url')?>/favicon.png" type="image/x-icon" >

    <link rel="stylesheet" type="text/css" media="all" href="<?=config('app.url')?>/bootstrap-4.3.1/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" media="all" href="<?=config('app.url')?>/css/all.css" >
    <link rel="stylesheet" type="text/css" media="all" href="<?=config('app.url')?>/css/style.css" >

    <!-- datatables css -->
    <!--link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/ -->

    <script src='<?=config('app.url')?>/js/jquery-3.4.0.min.js'></script>
    <script src='<?=config('app.url')?>/bootstrap-4.3.1/js/bootstrap.min.js'></script>

    <!-- datatables js -->
    <!-- script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script -->

    <script type="text/javascript" src="<?=config('app.url')?>/js/myapp.js"></script>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/ru/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                <!--
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
                -->
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel
        </div>

        <div class="links">
            <!--a href="{{ url('/companies') }}">Companies</a>
            <a href="{{ url('/employees') }}">Employees</a -->
            @auth
                <a href="{{ url('/ru/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
            @endauth

        </div>
    </div>
</div>
</body>
</html>
