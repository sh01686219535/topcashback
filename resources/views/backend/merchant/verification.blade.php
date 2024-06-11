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
<div class="contasiner physically-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-head  m-5">
                    <form action="{{  route('verification',$qrCode->id) }}" method="post" id="form-1" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" id="offer_id" value="{{ $qrCode->offer->id }}" name="offer_id" class="form-control my-2">
                        <div class="modal-content">
                            @include('error')

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Physically Approve</h1>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="my-1"  for="phone_number">Qr Code</label><br>
                                            <input id="qrcode" value="{{$qrCode->qr_code }}" name="qr_code" class="form-control my-2">
                                         </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="my-1"  for="phone_number">Search by Phone Number</label><br>
                                            {{-- <input id="user_id" value="{{ $qrCode->user->phone }}" name="user_id" class="form-control my-2"> --}}
                                            <select name="user_id" id="user_id" class="form-control my-2">
                                                <option value="">Select A user</option>
                                                @foreach($user as $value)
                                                <option value="{{ $value->id }}" {{  $value->id == $qrCode->user_id ? 'selected' : ''}}>{{ $value->phone }}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="my-1"  for="offer_id">Offer Name</label><br>
                                            <input id="offer_title" value="{{ $qrCode->offer->offer_title }}" name="offer_title" class="form-control my-2">
                                         </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="area" class="my-1">Area</label><br>
                                            <select name="merchant_id" id="area" class="form-control my-2">
                                            @foreach($merchant as $merchants)
                                            <option value="{{$merchants->id}}"{{$merchants->id == $qrCode->merchant_id ? 'selected' : ''}}>{{ $merchants->areas->areaName }}</option>
                                            @endforeach    
                                            </select>
                                            <!-- <input id="merchant_id" value="{{$qrCode->merchant->areas->areaName}}" name="merchant_id" > -->
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="my-2 minimum" for="offer_id">Total Purchase Amount <span style="color:red;">(You have to purchase minimum 1000$)</span></label><br>
                                   <input type="text" id="purchase_amount" name="purchase_amount" value="{{ $qrCode->purchase_amount }}" class="form-control first-line" placeholder="Emter Total Purchase Amount">
                                </div>

                                <div class="control">
                                    @if($qrCode->offer_amount)
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" name="fixed_amount" id="fixed_amount_offer">
                                        Fixed Amount of Offer
                                        <label class="form-check-label" for="inlineRadio1"></label>
                                    </div>
                                    <div>
                                        <input type="text" class="disabled-1 form-control" name="fixed_amount" id="fixed_amount" value="{{ $qrCode->offer_amount }}" placeholder="Enter Fixed Amount">
                                    </div>
                                    @elseif($qrCode->percentage_amount)
                                        <div class="form-check form-check-inline my-2">
                                            <input class="form-check-input" type="radio" name="percentage_amount" id="percentage_amount_offer" >
                                            Percentage Amount of Offer
                                            <label class="form-check-label" for="inlineRadio2"></label>
                                        </div>
                                        <input type="text" class="disabled form-control percentage_amount_1" name="percentage_amount" id="percentage_amount" value="{{ $qrCode->percentage_amount  }}" placeholder="Enter Percentage amount">
                                    @endif
                                   </div>
                                   <div>
                                    <label for="receipt" class="my-2">Courier invoice/Purchase Invoice </label>
                                    <input type="file" class="form-control my-2" name="receipt" id="receipt" required>
                                    </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary my-3" value="Verify">
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('js')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
     $(document).on('keyup click','#purchase_amount,.percentage_amount',function () {
        $unit_price = $('#purchase_amount').val();
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
    $(document).ready(function() {
        const imgPath = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        localStorage.setItem("image", reader.result);
    }, false);

    if (imgPath) {
        reader.readAsDataURL(imgPath);
    }
        $('#user_id_1').change(function() {
            var user_id = $(this).val();
            $.ajax({
                url: '/get-offers',
                type: 'post',
                dataType: 'json',
                data: 'user_id=' + user_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#offer_id').html(data);
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
