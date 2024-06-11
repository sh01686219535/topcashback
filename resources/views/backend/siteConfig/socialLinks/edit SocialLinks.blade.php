@extends('backend.layouts.app')
@section('title')
Edit Social Links
@endsection
@section('content')
<!-- Hoverable Table rows -->
<div class="contasiner customer-container">
   <div class="row">
      <div class="col-lg-12">
         <div class="card mb-3">
            <div class="card mb-2">
               <div class="card-head mx-5 my-3 customer-card">
                  <div class="left">

                   <h3>Edit Social Links</h3>
                  </div>
                  <div class="search">
                     <a href="{{ route('addSocialLinks') }}" class="btn btn-primary" title="Add Category">
                     <i class="fa-sharp fa-solid fa-list"></i>
                     Create Social</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <form class="form_1" action="{{route('editSocialLinks',$social_links->id)}}" method="post" enctype="multipart/form-data">
                  @csrf
                  @include('error')
                  <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                           <label for="placeName"><strong>Social Name</strong></label>
                          <input class="form-control" value="{{ $social_links->social_name }}" type="text" name="social_name" placeholder="Enter Social Name">
                        </div>
                        <div class="form-group">
                            <label for="placeName"><strong>Social Icon</strong></label>
                           <input class="form-control" type="file" value="{{ $social_links->social_logo }}" id="image" name="social_logo" placeholder="Enter Social Icon">
                           <img id="showImage" src="{{asset('admin/assets/social_icons/'. $social_links->social_logo)}}" alt="" class="image-style mb-3">
                         </div>
                         <div class="form-group">
                            <label for="placeName"><strong>Social Links</strong></label>
                           <input class="form-control" type="text" value="{{ $social_links->social_links }}" name="social_links" placeholder="Enter Social Links">
                         </div>
                    </div>
                  </div>
                  <div class="form-group">

                    <input type="submit" value="Save" class=" my-2 btn btn-info">


                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!--/ Hoverable Table rows -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
