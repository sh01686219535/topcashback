@extends('backend.layouts.app')
@section('title')
    Update Merchant
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3 p-3">
                    <div class="card-head  customer-card">
                        <div class="left">
                            <h3>Merchant Update</h3>
                        </div>
                        <div class="search">
                            <a href="{{route('merchant')}}" class="btn btn-primary" title="Add Category" >
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Merchant List</a>
                        </div>

                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                    <form action="{{route('update.merchant')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="merchant_id" value="{{$merchant->id}}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name"><strong>Merchant Full Name</strong></label>
                                            <input type="text" id="name" name="merchant_name" value="{{ $merchant->merchant_name }}" placeholder="Enter Merchant Full Name" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="company_name"><strong>Company Name</strong></label>
                                            <input type="text" id="company_name" name="company_name" value="{{ $merchant->company_name }}"  placeholder="Enter Company Name" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="number"><strong>Merchant Contact Number</strong></label>
                                            <input type="text" id="number" value="{{ $merchant->merchant_number }}" name="merchant_number" placeholder="Enter Merchant Contact Number" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="number"><strong>Merchant Secondary  Contact Number</strong></label>
                                            <input type="text" id="merchant_secondary_number" name="merchant_secondary_number" value="{{ $merchant->merchant_secondary_number }}" placeholder="Enter Merchant Secondary Number" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="email"><strong>Merchant Email <span class="text-danger color-m"> *</span></strong></label>
                                            <input type="email" id="email" name="merchant_email" value="{{ $merchant->merchant_email }}"  placeholder="Enter Merchant Email" class="form-control my-2">
                                        </div>

                                        <div class="input-group input-group-merge form-group">
                                            <label for="password" class="my-2"><strong>Merchant Password</span></strong></label>
                                            <div class="input-group">
                                                <input

                                                    type="password"
                                                    id="password"
                                                    class="form-control"
                                                    name="merchant_password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="merchant_password"
                                                />
                                                <span class="input-group-text cursor-pointer_1"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>

                                        <div class="input-group input-group-merge form-group">
                                            <label for="password" class="my-2"><strong>Merchant Confirm Password </strong></label>
                                            <div class="input-group">
                                                <input

                                                    type="password"
                                                    id="confirm_password"
                                                    class="form-control"
                                                    name="merchant_confirm"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="merchant_password"
                                                />
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="image"><strong>Marchent Image</strong></label>
                                            <input type="file" class="form-control my-2" name="merchant_image"  value="{{$merchant->merchant_image }}" id="image"/>
                                            @if ($merchant->merchant_image)

                                            <img id="showImage" src="{{asset('admin/assets/merchant-image/'.$merchant->merchant_image)}}" alt="" class="image-style mb-3">
                                            @else
                                            <img id="showImage" src="{{asset('admin')}}/assets/img/avatars/noImage.jpg" alt="" class="image-style mb-3">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="city"><strong>Address <span class="text-danger color-m"> *</span></strong></label>
                                            <input type="text" id="address" name="address" value="{{ $merchant->address }}"  placeholder="Enter address" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="city"><strong>City</strong></label>
                                            <input type="text" id="city" name="city" value="{{ $merchant->city }}" placeholder="Enter City" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="area"><strong>Area <span class="text-danger color-m"> *</span></strong></label>
                                            <select id="area" name="area" class="form-select my-2">
                                            <option selected="">Select Area</option>
                                                @foreach($area as $items)
                                                <option value="{{$items->id}}"{{$items->id == $merchant->area ? 'selected' : ''}}>{{$items->areaName}}</option>
                                                @endforeach
                                            </select>
                                            <!-- <input type="text" id="area" name="area" value="{{ $merchant->area }}" placeholder="Enter Area" class="form-control my-2"> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="postcode"><strong>Postcode <span class="text-danger color-m"> *</span></strong></label>
                                            <input type="text" id="postcode" name="postcode" value="{{ $merchant->postcode }}" placeholder="Enter Postcode" class="form-control my-2" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-primary">
                                <hr>
                            </form>
                            <div id="map" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4Q5eWuRggdxRTQDghITcoviXnYOLoU9k&libraries=places&callback=initMap"></script>
<script>
    $(document).ready(function () {
        $(".cursor-pointer_1").click(function () {
            var passwordInput = $("#password");
            var icon = $(this).find("i");
            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                icon.removeClass("bx-hide").addClass("bx-show");
            } else {
                passwordInput.attr("type", "password");
                icon.removeClass("bx-show").addClass("bx-hide");
            }
        });
    });
       $(document).ready(function () {
            $(".cursor-pointer").click(function () {
            var confirmPasswordField = $("#confirm_password");
            var icon = $(this).find("i");

            if (confirmPasswordField.attr("type") === "password") {
                confirmPasswordField.attr("type", "text");
                icon.removeClass("bx-hide").addClass("bx-show");
            } else {
                confirmPasswordField.attr("type", "password");
                icon.removeClass("bx-show").addClass("bx-hide");
            }
            });
        });
</script>
<script>
    $(document).ready(function(){
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
         var to = 'location';
         // autocomplete = new google.maps.places.Autocomplete((document.getElementById(to)),{
         //    types:['geocode'],
         // });
        google.maps.event.addListener(autocomplete,'place_changed',function () {
            var near_place = autocomplete.getPlace();
            $('#latitude').val(near_place.geometry.location.lat());
            $('#longitude').val(near_place.geometry.location.lng());
        });
    });
</script>
<script>
    // Initialize the map and marker
    function initMap() {
        var mapOptions = {
            center: { lat: 23.8041, lng: 90.4152 }, // Initial center of the map
            zoom: 10, // Initial zoom level
        };

        // Create the map
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Create a marker at the initial location (uluru)
        const uluru = { lat: 23.8041, lng: 90.4152 };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });

        // Add a dragend event listener to the marker
        marker.addListener('dragend', function(event) {
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();

            // Set latitude and longitude values in the form fields
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
        });
    }

    // Call the initMap function when the page loads
    window.onload = function() {
        initMap();
    };
    $(document).ready(function(){
        $('#image').change('click',function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endpush
