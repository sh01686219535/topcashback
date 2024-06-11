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
    <div class="contasiner customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head  m-5">
                        
                       <div class="customer-card">
                           <div class="row">
                            <div class="col-lg-12">
                                @foreach($userBalances as $userId => $balance)
                                    <p>User ID: {{ $userId }}</p>
                                    <p>Balance: {{ $balance }}</p>
                            
                                    <form action="{{route('payout',['userId' => $userId]) }}" method="POST">
                                        @csrf
                                        <input type="submit" value="Payout" name="submit" {{ $balance >= 3 ? '' : 'disabled' }}>
                                    </form>
                                @endforeach
                            </div>
                            
                            
                           </div>
                       </div>
                    </div>
                    
                </div>
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
