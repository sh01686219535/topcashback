@extends('backend.layouts.app')
@section('title')
Edit About
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>About Update</h3>
                        </div>
                        <div class="search">
                            <a href="{{ route('about') }}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                About List</a>

                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{ route('update.about') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="About_id" value="{{$About->id}}">
                                <div class="form-group">
                                    <label for="about_itle"><strong>About Title</strong></label>
                                    <input type="text" id="about_itle"value="{{$About->about_itle}}" name="about_itle" placeholder="Enter About Title" class="form-control my-2">
                                </div>
                                <div class="form-group">
                                    <label for="about_image"><strong>Image</strong></label>
                                    <input type="file" id="about_image" name="about_image" class="form-control my-2">
                                    <img id="show_img" src="{{asset('admin/assets/about-image/'.$About->about_image)}}" style="width:150px;height:150px; border-radius:15px;" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="image_description"><strong>Image Description</strong></label>
                                    <textarea name="image_description" id="image_description" class="form-control my-2">{{$About->image_description}}</textarea>
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
<script>
    $(document).ready(function(){
        $('#about_image').change(function (e) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#show_img').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endpush







