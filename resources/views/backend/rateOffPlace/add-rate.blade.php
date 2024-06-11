@extends('backend.layouts.app')
@section('title')
    Add Rate Off Place
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Rate Off Place Create</h3>
                        </div>
                        <div class="search">
                            <a href="{{route('rate.ogg.place')}}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Rate Off Place List</a>
                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{route('store.rateOffPlace')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="placeName"><strong>Location</strong></label>
                                    <input type="text" id="placeName" name="placeName" placeholder="Enter Place Name" class="form-control my-2">
                                </div>
                                <div class="form-group">
                                    <label for="ratePlace"><strong>Package</strong></label>
                                    <input type="text" id="ratePlace" name="ratePlace" placeholder="Rate Off Place Name" class="form-control my-2">
                                </div>
                                <!-- @if(Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id =='NULL')
                                <div class="form-group">
                                    <label for="merchant_id"><strong>Merchant Area</strong></label>
                                    <select name="merchant_id" id="merchant_id" class="form-select my-2">
                                        <option value="">Select Merchant Area</option>
                                        @foreach($merchant as $merchants)
                                        <option value="{{$merchants->id}}">{{$merchants['areas']['areaName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                @endif -->
                                <input type="submit" value="Submit" class="btn btn-primary my-3">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

