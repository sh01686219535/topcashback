@extends('backend.layouts.app')
@section('title')
    Add Permission
@endsection
@section('content')
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Permission Create</h3>
                        </div>
                        <div class="search">
                            <a href="{{route('permission')}}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Permission List</a>
                        </div>
                    </div>
                </div>
                @include('error')
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{route('store.permission')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="module_id"><strong>Module Name</strong></label>
                                    <select name="module_id" id="module_id" class="form-control my-2">
                                        <option value="">---Select Module---</option>
                                        @foreach($module as $modules)
                                            <option value="{{$modules->id}}">{{$modules->module_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sub_module_id"><strong>Sub Module Name</strong></label>
                                    <select name="sub_module_id" id="sub_module_id" class="form-control my-2">
                                        <option value="">---Select Sub Module---</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="permission_name"><strong>Permission Name</strong></label>
                                    <input type="text" id="permission_name" name="permission_name" placeholder="Permission Name" class="form-control my-2">
                                </div>
                                <input type="submit" value="Submit" class="btn btn-primary my-3">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  

    <script>
        $(document).ready(function () {
            $('#module_id').change(function () {
                var module_id = $(this).val();
                $.ajax({
                    url: '/get-permission',
                    type: 'POST',
                    dataType: 'json',
                    data:'module_id='+module_id,
                    success: function (data) {
                        $('#sub_module_id').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection










