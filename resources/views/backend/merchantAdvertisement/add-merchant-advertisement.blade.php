@extends('backend.layouts.app')
@section('title')
    Merchant Create Rate Off Place
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Merchant Rate Off Place Create</h3>
                        </div>
                        <div class="search">
                            <a href="{{route('merchant.advertisement')}}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Merchant Rate Off Place List</a>
                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{route('save.merchant.rate')}}" method="get" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="placeName"><strong>Location</strong></label>
                                    <!-- <input type="text" id="placeName" name="placeName" placeholder="Enter Place Name" class="form-control my-2"> -->
                                    <select name="placeName" id="placeName" class="form-select my-2">
                                        <option value="">Select Location</option>
                                        @foreach($rate as $item)
                                        <option value="{{$item->id}}">{{$item->placeName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ratePlace"><strong>Package</strong></label>
                                    <!-- <input type="text" id="ratePlace" name="ratePlace" placeholder="Rate Off Place Name" class="form-control my-2"> -->
                                    <select name="ratePlace" id="ratePlace" class="form-select my-2">
                                        <option value="">Select Package</option>
                                    </select>
                                </div>

                               <div class="form-group">
                                    <label for="merchant_id"><strong>Merchant Area</strong></label>
                                    <select name="merchant_id" id="merchant_id" class="form-select my-2">
                                        <option value="">Select Merchant Area</option>
                                        @foreach($merchant as $merchants)
                                        <option value="{{$merchants->id}}">{{$merchants->areas->areaName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="submit" value="Save & Pay" class="btn btn-primary my-3">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#placeName').change(function(){
            var placeValue = $(this).val();
            $.ajax({
                url: '/get-place-rate',
                type: 'post',
                dataType: 'json',
                data: 'placeValue=' + placeValue,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // console.log(data);
                    $('#ratePlace').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

    });
</script>

<!--
    $(document).ready(function() {
        $('#placeName').change(function() {
            var placeValue = $(this).val();
            console.log(placeValue);
            $.ajax({
                url: '/get-offers',
                type: 'post',
                dataType: 'json',
                data: 'placeValue=' + placeValue,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#ratePlace').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    }); -->

@endpush
