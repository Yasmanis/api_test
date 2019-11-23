<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Laravel Test 2019</title>
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/starter-template.css')}}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Customer</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="{{route('customer_form_create')}}">Customer Form</a>
                    <a class="dropdown-item" href="{{route('customer_list')}}">Customer List</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Product</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="{{route('product_form_create')}}">Product Form</a>
                    <a class="dropdown-item" href="{{route('product_list')}}">Product List</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('login_form')}}">Login</a>
            </li>
        </ul>
    </div>
</nav>

<main role="main" class="container main-vertical-center">
    <div class="starter-template div-vertical-center">
        <h1>Laravel Test 2019</h1>
        <p class="lead">This is a Laravel Test.</p>
    </div>
</main>
</body>
<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
<script>window.jQuery || document.write('<script src="{{asset('assets/js/jquery-3.3.1.js')}}"><\/script>')</script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
</html>
