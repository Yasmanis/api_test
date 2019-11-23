@extends('layout.app')

@section('title', 'Customer')

@section('navbar_ul')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item dropdown active">
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
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('login_form')}}">Login</a>
        </li>
    </ul>
@endsection

@section('content')
    @if (isset($edit_mode))
        {{ Form::model($customer, ['id' => 'form','class' => 'center-element form-create-edit']) }}
        <h1 class="text-center text-muted">Customer Edit Form</h1>
    @else
        {{ Form::open(['id' => 'form', 'class' => 'center-element form-create-edit']) }}
        <h1 class="text-center text-muted">Customer Create Form</h1>
    @endif

    <div class="form-row">
        <div class="form-group col-md-6">
            {{ Form::label('uuid', 'uuid') }}
            {{ Form::text('uuid', old('uuid'), ['class' => 'form-control', 'maxlength' => 255, 'required']) }}
            <div id="uuid_error" class="alert alert-danger d-none"></div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('firstName', 'First Name') }}
            {{ Form::text('firstName', old('firstName'), ['class' => 'form-control', 'maxlength' => 255, 'required']) }}
            <div id="firstName_error" class="alert alert-danger d-none"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {{ Form::label('lastName', 'Last Name') }}
            {{ Form::text('lastName', old('lastName'), ['class' => 'form-control', 'maxlength' => 255, 'required']) }}
            <div id="lastName_error" class="alert alert-danger d-none"></div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('status', 'Status') }}
            {{ Form::select('status', ['new' => 'new', 'pending' => 'pending', 'in review' => 'in review', 'approved' => 'approved', 'inactive' => 'inactive', 'deleted' => 'deleted'], old('status'), ['class' => 'form-control']) }}
            <div id="status_error" class="alert alert-danger d-none"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {{ Form::label('dateOfBirth', 'Date of Birth:') }}
            @if (isset($edit_mode))
                {{ Form::date('dateOfBirth', old('dateOfBirth'),['class' => 'form-control', 'required']) }}
            @else
                {{ Form::date('dateOfBirth', \Carbon\Carbon::now(),['class' => 'form-control', 'required']) }}
            @endif
            <div id="dateOfBirth_error" class="alert alert-danger d-none"></div>
        </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary btn-block"><?=isset($edit_mode) ? 'Save' : 'Create'?></button>

    {{ Form::close() }}

    <div class="modal fade" id="userAuthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
        $(document).ready(function () {

            @if (Cache::pull('auth'))
            $("#userAuthModal .modal-body").text('The user has been correctly authenticated.');
            $("#userAuthModal .modal-title").text('Congratulations!!!');
            $("#userAuthModal").modal('show');
            @endif

            $("button[type=submit]").click(function (e) {

                e.preventDefault();
                var customer = new FormData();
                customer.append("uuid", $("input[name=uuid]").val());
                customer.append("firstName", $("input[name=firstName]").val());
                customer.append("lastName", $("input[name=lastName]").val());
                customer.append("dateOfBirth", $("input[name=dateOfBirth]").val());
                customer.append("status", $("select[name=status]").val());
                customer.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    type: 'POST',
                    @if (isset($edit_mode))
                    url: "/api/customers/{{$customer->id}}?api_token={{Cache::get('api_token')}}",
                    data: {
                        "uuid": $("input[name=uuid]").val(),
                        "firstName": $("input[name=firstName]").val(),
                        "lastName": $("input[name=lastName]").val(),
                        "dateOfBirth": $("input[name=dateOfBirth]").val(),
                        "status": $("select[name=status]").val(),
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        "_method": "put"
                    },
                    @else
                    url: "/api/customers?api_token={{Cache::get('api_token')}}",
                    data: customer,
                    processData: false,
                    contentType: false,
                    @endif

                    success: function (result, status, xhr) {
                        @if (isset($edit_mode))
                        $("#userAuthModal .modal-body").text('The customer has been correctly updated. Redirecting...');
                        $("#userAuthModal .modal-title").text('Congratulations!!!');
                        $("#userAuthModal").modal('show');
                        @else
                        $("#userAuthModal .modal-body").text('The customer has been correctly saved. Redirecting...');
                        $("#userAuthModal .modal-title").text('Congratulations!!!');
                        $("#userAuthModal").modal('show');
                        $('#form').trigger("reset");
                        @endif
                        console.log("Respond was: ", result);
                        $("input[name=uuid]").removeClass('is-invalid');
                        $("#uuid_error").html(``);
                        $("#uuid_error").addClass('d-none');
                        $("input[name=firstName]").removeClass('is-invalid');
                        $("#firstName_error").html(``);
                        $("#firstName_error").addClass('d-none');
                        $("input[name=lastName]").removeClass('is-invalid');
                        $("#lastName_error").html(``);
                        $("#lastName_error").addClass('d-none');
                        $("input[name=dateOfBirth]").removeClass('is-invalid');
                        $("#dateOfBirth_error").html(``);
                        $("#dateOfBirth_error").addClass('d-none');

                        setTimeout(function () {
                            console.log("Redirecting...");
                            window.location.href = "/customer/list";
                        }, 3000);
                    },
                    error: function (result, status, xhr) {
                        console.log("There was an error: ", JSON.parse(result.responseText).errors);
                        console.log(window.location.pathname);
                        if (JSON.parse(result.responseText).error == 'Unauthenticated') {
                            {{Cache::put('full_url', URL::current())}}
                            $("#userAuthModal .modal-body").text('You token has expired. You must login again!');
                            $("#userAuthModal .modal-title").text('Sorry');
                            $("#login_again").removeClass('d-none');
                            $("#userAuthModal").modal('show');
                        } else {
                            if (JSON.parse(result.responseText).errors.uuid) {
                                $("input[name=uuid]").addClass('is-invalid');
                                $("#uuid_error").html(`<p>${JSON.parse(result.responseText).errors.uuid}</p>`)
                                $("#uuid_error").removeClass('d-none');
                            } else {
                                $("input[name=uuid]").removeClass('is-invalid');
                                $("#uuid_error").html(``);
                                $("#uuid_error").addClass('d-none');
                            }
                            if (JSON.parse(result.responseText).errors.firstName) {
                                $("input[name=firstName]").addClass('is-invalid');
                                $("#firstName_error").html(`<p>${JSON.parse(result.responseText).errors.firstName}</p>`)
                                $("#firstName_error").removeClass('d-none');
                            } else {
                                $("input[name=firstName]").removeClass('is-invalid');
                                $("#firstName_error").html(``);
                                $("#firstName_error").addClass('d-none');
                            }
                            if (JSON.parse(result.responseText).errors.lastName) {
                                $("input[name=lastName]").addClass('is-invalid');
                                $("#lastName_error").html(`<p>${JSON.parse(result.responseText).errors.lastName}</p>`)
                                $("#lastName_error").removeClass('d-none');
                            } else {
                                $("input[name=lastName]").removeClass('is-invalid');
                                $("#lastName_error").html(``);
                                $("#lastName_error").addClass('d-none');
                            }
                            if (JSON.parse(result.responseText).errors.dateOfBirth) {
                                $("input[name=dateOfBirth]").addClass('is-invalid');
                                $("#dateOfBirth_error").html(`<p>${JSON.parse(result.responseText).errors.dateOfBirth}</p>`)
                                $("#dateOfBirth_error").removeClass('d-none');
                            } else {
                                $("input[name=dateOfBirth]").removeClass('is-invalid');
                                $("#dateOfBirth_error").html(``);
                                $("#dateOfBirth_error").addClass('d-none');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
