@extends('layout.app')

@section('title', 'Product')

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

        <li class="nav-item dropdown active">
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
@endsection

@section('content')
    @if (isset($edit_mode))
        {{ Form::model($product, ['id' => 'form', 'class' => 'center-element form-create-edit']) }}
        <h1 class="text-center text-muted">Product Edit Form</h1>
    @else
        {{ Form::open(['id' => 'form', 'class' => 'center-element form-create-edit']) }}
        <h1 class="text-center text-muted">Product Create Form</h1>
    @endif

    <div class="form-row">
        <div class="form-group col-md-6">
            {{ Form::label('issn', 'issn') }}
            {{ Form::text('issn', old('issn'), ['class' => 'form-control', 'maxlength' => 255, 'required']) }}
            <div id="issn_error" class="alert alert-danger d-none"></div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', old('name'), ['class' => 'form-control', 'maxlength' => 255, 'required']) }}
            <div id="name_error" class="alert alert-danger d-none"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {{ Form::label('customer', 'Customer') }}
            {{ Form::select('customer', $customers, old('customer'), ['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('status', 'Status') }}
            {{ Form::select('status', ['new' => 'new', 'pending' => 'pending', 'in review' => 'in review', 'approved' => 'approved', 'inactive' => 'inactive', 'deleted' => 'deleted'], old('status'), ['class' => 'form-control']) }}
        </div>
    </div>


    <button type="submit" class="btn btn-lg btn-primary btn-block"><?=isset($edit_mode) ? 'Save': 'Create'?></button>

    {{ Form::close() }}

    <div class="modal fade" id="userAuthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <a id="login_again" class="btn btn-primary d-none" href="/auth" role="button">Login</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('view_asset_code')
    <script>
        $(document).ready(function()
        {

            @if (Cache::pull('auth'))
            $("#userAuthModal .modal-body").text('The user has been correctly authenticated.');
            $("#userAuthModal .modal-title").text('Congratulations!!!');
            $("#userAuthModal").modal('show');
            @endif

            $("button[type=submit]").click(function(e){

                e.preventDefault();
                var product = new FormData();
                product.append("issn",$("input[name=issn]").val());
                product.append("name",$("input[name=name]").val());
                product.append("customer",$("select[name=customer]").val());
                product.append("status",$("select[name=status]").val());
                product.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    type:'POST',
                    @if (isset($edit_mode))
                    url:"/api/products/{{$product->id}}?api_token={{Cache::get('api_token')}}",
                    data: {
                        "issn":$("input[name=issn]").val(),
                        "name":$("input[name=name]").val(),
                        "customer":$("select[name=customer]").val(),
                        "status":$("select[name=status]").val(),
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        "_method":"put"
                    },
                    @else
                    url:"/api/products?api_token={{Cache::get('api_token')}}",
                    data: product,
                    processData: false,
                    contentType: false,
                    @endif

                    success:function (result, status, xhr) {
                        @if (isset($edit_mode))
                        $("#userAuthModal .modal-body").text('The product has been correctly updated. Redirecting...');
                        $("#userAuthModal .modal-title").text('Congratulations!!!');
                        $("#userAuthModal").modal('show');
                        @else
                        $("#userAuthModal .modal-body").text('The product has been correctly saved. Redirecting...');
                        $("#userAuthModal .modal-title").text('Congratulations!!!');
                        $("#userAuthModal").modal('show');
                        $('#form').trigger("reset");
                        @endif
                        console.log("Respond was: ", result);
                        $("input[name=issn]").removeClass('is-invalid');
                        $("#issn_error").html(``);
                        $("#issn_error").addClass('d-none');
                        $("input[name=name]").removeClass('is-invalid');
                        $("#name_error").html(``);
                        $("#name_error").addClass('d-none');

                        setTimeout(function() {
                            console.log("Redirecting...");
                            window.location.href = "/product/list";
                        }, 3000);
                    },
                    error:function (result, status, xhr) {
                        console.log("There was an error: ", JSON.parse(result.responseText).errors);
                        console.log(window.location.pathname);
                        if(JSON.parse(result.responseText).error == 'Unauthenticated')
                        {
                            {{Cache::put('full_url', URL::current())}}
                            $("#userAuthModal .modal-body").text('You token has expired. You must login again!');
                            $("#userAuthModal .modal-title").text('Sorry');
                            $("#login_again").removeClass('d-none');
                            $("#userAuthModal").modal('show');
                        }else{
                            if(JSON.parse(result.responseText).errors.issn){
                                $("input[name=issn]").addClass('is-invalid');
                                $("#issn_error").html(`<p>${JSON.parse(result.responseText).errors.issn}</p>`);
                                $("#issn_error").removeClass('d-none');
                            }else{
                                $("input[name=issn]").removeClass('is-invalid');
                                $("#issn_error").html(``);
                                $("#issn_error").addClass('d-none');
                            }
                            if(JSON.parse(result.responseText).errors.name){
                                $("input[name=name]").addClass('is-invalid');
                                $("#name_error").html(`<p>${JSON.parse(result.responseText).errors.name}</p>`);
                                $("#name_error").removeClass('d-none');
                            }else{
                                $("input[name=name]").removeClass('is-invalid');
                                $("#name_error").html(``);
                                $("#name_error").addClass('d-none');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
