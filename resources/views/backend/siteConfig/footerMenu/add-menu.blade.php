@extends('backend.layouts.app')
@section('title')
Create Menu
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Footer Menu Create</h3>
                        </div>
                        <div class="search">
                            <a href="{{ route('footer.menu') }}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Footer Menu</a>

                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{ route('store.menu') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="footer_menu"><strong>Footer Menu</strong></label>
                                    <input type="text" id="footer_menu" name="footer_menu" placeholder="Enter Footer Menu" class="form-control my-2">
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







