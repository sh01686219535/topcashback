@extends('backend.layouts.app')



@section('title')
Payout Dashboard
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
                    <div class="card-head  mx-5 my-3">

                       <div class="customer-card">
                        <h1 class="">Payout Dashboard</h1>
                           
                       </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><strong>User</strong></th>
                                <th><strong>Amount</strong></th>
                                <th><strong>Requested Date</strong></th>
                                <th><strong>Action</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payouts as $payout)
                            <tr>
                                <td>{{ $payout->user->name }}</td>
                                <td>{{ $payout->amount }}</td>
                                <td>{{ \Carbon\Carbon::create($payout->created_at)->format('d M Y') }}</td>
                                <td>
                                       
                                    <a class="btn btn-success"href="{{ route('approvePayout',[$payout->id,'approve']) }}">Approve</a>
                                
                                    <a class="btn btn-danger" href="{{ route('approvePayout',[$payout->id,'declined']) }}">Declined</a>
                                
                                </td>
                               </tr>     
                            @endforeach()
                            </tbody>
                        </table>
                        {{ $payouts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Hoverable Table rows -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#approveButton').click(function() {
            // Update button text to "Approved"
            $(this).text('Approved');
            // Add the 'approved' class to change its appearance
            $(this).addClass('approved');
        });
    });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {


        });
        function cssPrint() {

            print();
        }
    </script>
@endsection
