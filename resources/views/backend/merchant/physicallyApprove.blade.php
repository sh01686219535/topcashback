@extends('backend.layouts.app')
@section('title')
    Physically Approve
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .disabled{
        display: none;
    }
    .disabled-1{
        display: none;
    }
</style>
@endpush
@section('content')
<!-- Modal -->
<div class="contasiner customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-head  m-5">
                    <form action="{{ route('physicallyApprove') }}" method="POST" id="form-1">
                        @csrf
                        <div class="modal-content">
                            @include('error')

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Physically Approve</h1>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="my-2"  for="phone_number">Search by Phone Number</label><br>
                                            <select id="user_id_1" name="user_id" class="form-control my-2 select2">
                                                @foreach ($user as $users)
                                                <option value="{{ $users->id }}">{{ $users->phone }}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="my-2"  for="offer_id">Offer Name</label><br>
                                            <select id="offer_id" name="offer_id" class="form-control my-2 select2">
                                                @foreach ($offer as $offers)
                                                <option value="{{ $offers->id }}">{{ $offers->offer_title }}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <select id="area" name="merchant_id" class="form-control my-2">
                                        <option selected="">Select An Area</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                <label class="my-2">You should purchase minimum Amount</label><br>
                                   <input type="text" id="minimum_purchase" {{ $someVariable ? 'disabled' : '' }} class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label class="my-2" id="minimum-purchase" for="offer_id">Total Purchase Amount </span></label><br>
                                   <input type="text" id="purchase_amount" name="purchase_amount" class="form-control first-line" placeholder="Emter Total Purchase Amount">

                                </div>

                                <div class="control">
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" name="fixed_amount" id="fixed_amount_offer">
                                        Fixed Amount of Offer
                                        <label class="form-check-label" for="inlineRadio1"></label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" name="percentage_amount" id="percentage_amount_offer" >
                                        Percentage Amount of Offer
                                        <label class="form-check-label" for="inlineRadio2"></label>
                                    </div>
                                    <div>
                                        <!-- <input type="text" class="disabled-1 form-control" id="fixed_amount" name="fixed_amount" placeholder="Enter your Fixed Commission"> -->
                                        <select  id="fixed_amount" name="offer_amount" class="disabled-1 form-select">
                                       <option value="">Select Fixed Amount</option>
                                        </select>
                                        <!-- <input type="text" class="disabled form-control" id="percentage_amount" name="percentage_amount" placeholder="Enter your Percentage Commission" > -->
                                        <select  id="percentage_amount" class="disabled form-select percentage_amount">
                                       <option value="">Select Percentage Amount</option>
                                        </select><br>
                                    </div>
                                    <div>
                                        <input type="text" class="disabled-1 form-control" name="fixed_amount" id="fixed_amount_1" placeholder="Enter Fixed Amount">
                                        <input type="text" class="disabled form-control percentage_amount_1" name="percentage_amount" id="percentage_amount_1" placeholder="Enter Percentage amount">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary my-3" value="Verify">

                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

        </div>
    </div>
</div>

@endsection
@push('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

<script>
$(document).ready(function() {
        $('#purchase_amount').on('change', function() {
            var minimumAmount = parseFloat($('#minimum_purchase').val());
            var enteredAmount = parseFloat($(this).val());
            // alert(minimumAmount);

            if (enteredAmount < minimumAmount) {
                alert('Purchase Amount must be equal to or greater than Minimum Purchase Amount.');
                // You can also reset the input field or take other actions.
                $(this).val('');
            }
        });
    });
</script> 

{{--  Calculation percentage --}}
<script>
     $(document).on('keyup click','#purchase_amount,.percentage_amount',function () {
        $unit_price = $('#purchase_amount').val();
        // console.log($unit_price);
        $buying_qty = $('.percentage_amount').val();
        $total =  ($unit_price * $buying_qty) / 100;
        $('.percentage_amount_1').val($total);
        // $(this).closest('tr').find('input.percentage_amount_1').val($total);
        totalAmount();
    });
    function totalAmount() {
        var sum = 0;
        $('.percentage_amount_1').each(function () {
            var value = $(this).val();
            if (!isNaN(value) && value.length !=0) {
                sum += parseFloat(value);
            }
        });
        // $('#estimated_amount').val(sum);
    }
</script>
<script>
    //minimum purchase
    $(document).ready(function() {
        $('#offer_id').change(function() {
            var offer_id = $(this).val();
            $.ajax({
                url: '/minimum-purchase',
                type: 'post',
                dataType: 'json',
                data: 'offer_id=' + offer_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#minimum_purchase').val(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

    //offer wise area
    $(document).ready(function() {
        $('#offer_id').change(function() {
            var offer_id = $(this).val();
            $.ajax({
                url: '/get-areas',
                type: 'post',
                dataType: 'json',
                data: 'offer_id=' + offer_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#area').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

     $(document).ready(function(){
        $('#fixed_amount_offer').click(function(){
            $('#fixed_amount').css("display", "block");
            // $('#fixed_amount_1').css("display", "block");
            $('#percentage_amount').hide();
            $('#percentage_amount_1').hide();
            $("#percentage_amount_offer").prop( "checked", false );
            $(this).prop( "checked", true );
        });
        $('#percentage_amount_offer').click(function(){
            $('#percentage_amount').css("display", "block");
            $('#percentage_amount_1').css("display", "block");
            $('#fixed_amount').hide();
            $('#fixed_amount_1').hide();
            $("#fixed_amount_offer").prop( "checked", false );
            $(this).prop( "checked", true );
        });
    });
    // $(document).ready(function(){
    //     $('#fixed_amount_offer').click(function(){
    //         $('#fixed_amount').css("display", "block");
    //         $('#fixed_amount_1').css("display", "block");
    //         $('#percentage_amount').hide();
    //         $('#percentage_amount_1').hide();
    //     });
    //     $('#percentage_amount_offer').click(function(){
    //         $('#percentage_amount').css("display", "block");
    //         $('#percentage_amount_1').css("display", "block");
    //         $('#fixed_amount').hide();
    //         $('#fixed_amount_1').hide();
    //     });
    // });


    $(document).ready(function () {
        $('#offer_id').change(function () {
            var offer_id = $(this).val();
            //  var offer_id = $('#offer_id').val();
            $.ajax({
                url:'/get-fixedAmount',
                type:'post',
                dataType: 'json',
                data: {offer_id:offer_id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                     $('#fixed_amount').html(data);
                },
                error:function(xhr,status,error){
                    console.error(xhe.responseText);
                }
            });
        });
    });
    $(document).ready(function () {
        $('#offer_id').change(function () {
            var offer_id = $(this).val();
            $.ajax({
                url:'/get-percentageAmount',
                type:'post',
                data:'offer_id='+offer_id,
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                     $('#percentage_amount').html(data);
                },
                error:function(xhr,status,error){
                    console.error(xhe.responseText);
                }
            });
        });
    });
</script>
@endpush
