@extends('backend.layouts.app')
@section('title')
    Merchant Update Rate Off Place
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Merchant Rate Off Place Update</h3>
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
                            <form action="{{route('update.merchant.rate')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="merchant_rate" value="{{$merchant->id}}">
                                <div class="form-group">
                                    <label for="placeName"><strong>Location</strong></label>
                                    <!-- <input type="text" id="placeName" name="placeName" placeholder="Enter Place Name" class="form-control my-2"> -->
                                    <select name="placeName" id="placeName" class="form-select my-2">
                                        <option value="">Select Location</option>
                                        @foreach($rate as $item)
                                        <option value="{{$item->id}}" {{$item->id == $merchant->placeName ? 'selected' : ''}}>{{$item->placeName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ratePlace"><strong>Package</strong></label>
                                    <!-- <input type="text" id="ratePlace" name="ratePlace" placeholder="Rate Off Place Name" class="form-control my-2"> -->
                                    <select name="ratePlace" id="ratePlace" class="form-select my-2">
                                        <option value="">Select Package</option>
                                        @foreach($rate as $item)
                                        <option value="{{$item->id}}" {{$item->ratePlace == $merchant->ratePlace ? 'selected' : ''}}>{{$item->ratePlace}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <input type="submit" value="Submit" class="btn btn-primary my-3">
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
