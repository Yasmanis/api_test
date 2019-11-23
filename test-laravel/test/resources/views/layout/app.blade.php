<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Formulario - @yield('title')</title>
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/starter-template.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/floating-labels.css')}}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        @yield('navbar_ul')
    </div>
</nav>

<main role="main" class="container">
    @yield('content')
</main>
</body>
<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
<script>window.jQuery || document.write('<script src="{{asset('assets/js/jquery-3.3.1.js')}}"><\/script>')</script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
@yield('view_asset_code')
</html>
