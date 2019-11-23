@extends('layout.app')

@section('title', 'Auth User')

@section('navbar_ul')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
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
        <li class="nav-item active">
            <a class="nav-link" href="{{route('login_form')}}">Login</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="container">
        {{ Form::open(['url' => '/api/login', 'class' => 'form-signin login-form']) }}
        <div class="text-center mb-4">
            <img class="mb-4" src="{{asset('assets/img/default-avatar.png')}}" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Login Form</h1>
        </div>

        <div class="form-label-group">
            {{ Form::email('email', old('email'), array('class' => 'form-control', 'maxlength' => 255, 'placeholder' => "Email address", "readonly" => "readonly")) }}
            {{ Form::label('email', 'Email address') }}
        </div>


        <div class="form-label-group">
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => "Password", 'readonly', "readonly" => "readonly"]) }}
            {{ Form::label('password', 'Password') }}
        </div>


        <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; Laravel Test -2019</p>


        {{ Form::close() }}
    </div>

@endsection


@section('view_asset_code')
    <script>
        $(document).ready(function () {
            $("input").focus(function(){
                $(this).removeAttr("readonly");
            });
        });
    </script>
@endsection
