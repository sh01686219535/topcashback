@extends('backend.layouts.app')
@section('title')
    Advertisement
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-head m-5 customer-card">
                        <div class="left">
                            <h3>Pay Advertisement</h3>
                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{route('store.advertisement')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="addLocation"><strong>Add Location</strong></label>
                                    <select name="addLocation" id="addLocation" class="form-select my-2">
                                        <option value="">Select Add Location</option>
                                        @foreach($ratePrice as $rates)
                                        <option value="{{$rates->id}}">{{$rates->placeName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price"><strong>Price</strong></label>
                                    <select name="price" id="price" class="form-select my-2">
                                        <option value="">Select Price</option>
                                    </select>
                                </div>
                                @if(Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id =='NULL')
                                <div class="form-group">
                                    <label for="merchant_id"><strong>Merchant Area</strong></label>
                                    <select name="merchant_id" id="merchant_id" class="form-select my-2">
                                        <option value="">Select Merchant Area</option>
                                        @foreach($merchant as $merchants)
                                        <option value="{{$merchants->id}}">{{$merchants->area}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                @endif
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
<script>
    $(document).ready(function () {
        $('#addLocation').change(function(){
            var location_id = $(this).val();

            $.ajax({
                url:'/get-price',
                type:'get',
                data:'location_id='+location_id,
                dataType:'json',
                success:function(data){
                    $('#price').html(data);
                },
                error:function(xhr,status, error){
                    console.error(xhr.responseTest);
                }
            });
        });
    });
</script>
@endpush
