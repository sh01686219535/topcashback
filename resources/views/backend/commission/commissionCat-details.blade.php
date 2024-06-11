@extends('backend.layouts.app')
@section('title')
Merchant wise details page
@endsection
@section('content')
<div class="container">
    <div class="row margin-bottom">
        <div class="col-lg-12">
            <div class="card">
                <div class="customer-card card-head mx-5 mt-5 mb-3" style="margin-top:-10px;">
                    <div class="area-h3">
                        <h2>Merchant wise commission</h2> </div>
                    <div class="print">
                        <a href="{{route('showMerchantCommissionStore')}}" class="btn btn-primary pdf">Merchant wise commission List</a>
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('merchantCommissionStore')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="qrCode_id" value="{{ $qrCode->id }}">
                        <div class="form-group">
                            <label for="merchant_id">Merchant Name</label>
                            <select name="merchant_id" id="merchant_id" class="form-control my-2">
                                @foreach($merchant as $values)
                                    <option value="{{ $values->id }}" {{ $values->id == $qrCode->merchant_id ? 'selected' : '' }}>
                                        {{ $values->merchant_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                                    <label for="offer_id">Offer</label>
                                    <select id="offer_id" name="offer_id" class="form-control my-2">
                                        @foreach($offer as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $qrCode->offer_id ? 'selected' : '' }}>
                                            {{ $item->offer_title }}
                                        </option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="my-2" id="minimum-purchase" for="offer_id"> Minimum Purchase Amount</span></label><br>
                                    <select id="minimum_amount" name="minimum_amount" class="form-control my-2" {{ $someVariable ? 'disabled' : '' }}>
                                        @foreach($offer as $items)
                                            <option value="{{ $items->minimum_perchase }}" {{ $items->id == $qrCode->offer_id ? 'selected' : '' }}>
                                                {{ $items->minimum_perchase }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="my-2" id="purchase_amount" for="offer_id">Enter Purchase Amount</span></label><br>
                                    <input type="text" id="purchase_amount_1" name="purchase_amount" placeholder="Enter Purchase Amount" class="form-control my-2">
                                </div>
                                <div class="form-group d-none">
                                    <label class="my-2" for="user_id">User Name</span></label><br>
                                    <input type="text" id="user_id" name="user_id" value="{{$qrCode->user_id}}" class="form-control my-2">
                                </div>
                                <div class="form-group d-none">
                                    <label class="my-2" for="qr_code_id">Qr Code Data</span></label><br>
                                    <input type="text" id="qr_code_id" name="qr_code_id" value="{{$qrCode->qr_code}}" placeholder="Enter Qr Code Amount" class="form-control my-2">
                                </div>
                                <div class="control">
                                    @if($qrCode->offer_amount)
                                    <div class=" my-2">
                                        {{-- <input class="form-check-input" type="radio" name="fixed_amount" id="fixed_amount_offer"> --}}

                                        <label class="form-check-label" for="inlineRadio1">Fixed Amount of Offer</label>
                                    </div>
                                    <div>
                                        <input type="text" class="disabled-1 form-control" value="{{ $qrCode->offer_amount }}" id="fixed_amount" name="fixed_amount" placeholder="Enter your Fixed Commission">
                                    </div>
                                    @else
                                    <div class=" my-2">

                                        Percentage Amount of Offer
                                        <label class="form-check-label" for="inlineRadio2"></label>
                                    </div>
                                    <div>
                                        <select  id="percentage_amount" class="form-control percentage_amount">
                                            <option value="{{ $qrCode->percentage_amount }} ">{{ $qrCode->percentage_amount }}</option>
                                        </select>
                                    </div><br>
                                    <div>
                                        <input type="text" class="form-control percentage_amount"  id="percentage_amount" name="percentage_amount" placeholder="Enter your Percentage Commission" value="">
                                    </div>
                                    @endif
                                    </div>
                            <div class="form-group d-none">
                                <label for="name1" class="mt-2">Admin Name</label>
                                <select name="admin_id" id="name1" class="form-control my-2">
                                    @foreach($admin as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == $qrCode->admin_id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="receipt" class="my-2">Courier invoice/Purchase Invoice </label>
                                <input type="file" class="form-control my-2" name="receipt" id="receipt" >
                            </div><br>
                            <!-- Your form fields here -->
                            <button class="btn btn-danger" type="submit">Calculate Commission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
   $(document).ready(function() {
        $('#purchase_amount_1').on('change', function() {
            var minimumAmount = parseFloat($('#minimum_amount').val());
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

<script>
    //
    $(document).on('keyup click','#purchase_amount_1,.percentage_amount',function () {
        $unit_price = $('#purchase_amount_1').val();
        $buying_qty = $('.percentage_amount').val();
        $total =  ($unit_price * $buying_qty) / 100;
        // console.log($total);
        $('.percentage_amount').val($total);
        // console.log($total);
        // console.log($total1);
        // $(this).closest('tr').find('input.percentage_amount_1').val($total);
        // totalAmount();
    });
    // function totalAmount() {
    //     var sum = 0;
    //     $('#percentage_amount').each(function () {
    //         var value = $(this).val();
    //         if (!isNaN(value) && value.length !=0) {
    //             sum += parseFloat(value);
    //         }
    //     });
        // $('#estimated_amount').val(sum);
    // }
    //
    $(document).ready(function(){
        $('#fixed_amount_offer').click(function(){
            $('#fixed_amount').css("display", "block");
            $('#percentage_amount').hide();
            $("#percentage_amount_offer").prop( "checked", false );
            $(this).prop( "checked", true );
        });
        $('#percentage_amount_offer').click(function(){
            $('#percentage_amount').css("display", "block");
            $('#fixed_amount').hide();
            $("#fixed_amount_offer").prop( "checked", false );
            $(this).prop( "checked", true );
        });
    });
</script>


@endpush
