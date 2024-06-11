@extends('backend.layouts.app')
@section('title')
 Site Info
@endsection


@section('content')

<!-- Hoverable Table rows -->
<div class="container customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-head m-3 customer-card">
                    <h3>Company Setting Information</h3>
                    <div class="search">
                        <i class="fa fa-info-circle me-2 btn btn-primary"></i>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('site.info.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="siteId" value="{{ $siteInfo->id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name"><strong>Company Name</strong></label>
                                    <input type="text" id="option_name" name="company_name" value="{{ $siteInfo->company_name }}" placeholder="Company Name" class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="email"><strong>Email</strong></label>
                                    <input type="text" id="option_value" name="email" value="{{ $siteInfo->email }}" placeholder="Company Email" class="form-control">
                                </div>
                                {{-- <div class="form-group mt-3">
                                    <label for="email"><strong>Mobile</strong></label>
                                    <input type="tel" id="mobile_number" name="mobile_number" placeholder="Mobile number will be here" class="form-control">
                                </div> --}}
                                <div class="form-group mt-3">
                                    <label for="image"><strong>Logo</strong></label>
                                    <input type="file" class="form-control my-2" name="logo" id="image_1" />
                                    <img id="showImage_1"  src="{{ asset( $siteInfo->logo ) }}" alt="" class="image-style mb-3">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="image"><strong>Favicon</strong></label>
                                    <input type="file" class="form-control my-2" name="favicon" id="image_2" />
                                    <img id="favicon_1"  src="{{ asset( $siteInfo->favicon ) }}" alt="" class="image-style mb-3">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="email"><strong>Short Description</strong></label>
                                    <textarea name="short_description" value="" placeholder="Enter a short description" class="form-control">{{ $siteInfo->short_description }}</textarea>

                                </div>
                                {{-- <div class="form-group">
                                    <label for="name"><strong>Service Charge(%)</strong></label>
                                    <input type="text" id="service_charge" name="service_charge" placeholder="Service Charge will be here..." value="" class="form-control">
                                </div> --}}
                                <input type="submit" value="Submit" class="btn btn-success my-3" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Hoverable Table rows -->
@push('js')
<script>
  $(document).ready(function(){
            $('#image_1').change(function (e) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage_1').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
        $(document).ready(function(){
            $('#image_2').change(function (e) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#favicon_1').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

</script>

@endpush


@endsection
