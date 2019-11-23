<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Customer List</title>
    <link href="{{asset('assets/css/bootstrap4.1.3.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
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
    </div>
</nav>

<main role="main" class="container main-vertical-separation">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>id</th>
            <th>issn</th>
            <th>Name</th>
            <th>Status</th>
            <th>Customer</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->issn}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->customer}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('product_form_edit', $product->id)}}" role="button">Edit</a>
                    <a class="btn btn-danger text-white" rel="{{$product->id}}" onclick="get_product_rel(this.rel)" role="button">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

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

</body>
<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
<script>window.jQuery || document.write('<script src="{{asset('assets/js/jquery-3.3.1.js')}}"><\/script>')</script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    function get_product_rel(rel){
        $.ajax({
            type: 'POST',
            url: "/api/products/"+ rel +"?api_token={{Cache::get('api_token')}}",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                "_method": "delete"
            },
            success: function (result, status, xhr) {
                $("#userAuthModal .modal-body").text('Product deleted successfully!');
                $("#userAuthModal .modal-title").text('Congratulations');
                $("#login_again").addClass('d-none');
                $("#userAuthModal").modal('show');
                setTimeout(function () {
                    console.log("Redirecting...");
                    window.location.href = "/product/list";
                }, 3000);
            },
            error: function (result, status, xhr) {
                if (JSON.parse(result.responseText).error == 'Unauthenticated') {
                    {{Cache::put('full_url', URL::current())}}
                    $("#userAuthModal .modal-body").text('You token has expired. You must login again!');
                    $("#userAuthModal .modal-title").text('Sorry');
                    $("#login_again").removeClass('d-none');
                    $("#userAuthModal").modal('show');
                }
            }
        })
    }
</script>

</html>
