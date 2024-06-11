@extends('backend.layouts.app')
@section('title')
    Merchant
@endsection
@section('content')
    <style>
        @media only print {
            body {
                visibility: hidden;
            }
            .table {
                visibility: visible;
            }
        }

    </style>
    <!-- Hoverable Table rows -->
    <div class="container">
        <div class="row">
            <h2>Generate lati & longi</h2>
            <div class="col-lg-12">
                <form class="form-group" action="{{ route('geocode') }}" method="POST">
                    @csrf
                    <input class="form-control" type="text" name="address" placeholder="Enter an address"><br>
                    <button class="btn btn-danger" type="submit">Geocode</button>
                </form>
            </div>
        </div>
    </div>
    <!--/ Hoverable Table rows -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {


        });
        function cssPrint() {

            print();
        }
    </script>
@endsection
