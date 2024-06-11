@extends('backend.layouts.app')



@section('title')
    Subcategory
@endsection
@section('content')
<!-- Modal -->
<div class="contasiner customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-head  m-5">




                    <form action="{{route('edit.subCategory',$subCategory->id)}}" method="post">
                        @csrf
                        <div class="modal-content">
                            @include('error')
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Sub Category Edit Page</h1>

                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="category_id">Category Name</label>
                                    <select id="category_id" name="category_id" class="form-control my-2">
                                        @foreach($category as $item)
                                        <option value="{{$item->id}}">{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sub_category_name">Sub Category Name</label>
                                    
                                    <input type="text" id="sub_category_name" name="sub_category_name"
                                    placeholder="Sub Category Name" value="{{ $subCategory->sub_category_name }}" class="form-control my-2" required>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Category</button>
                            </div>
                        </div>
                    </form>
    </div>
</div>
</div>
</div>
</div>

@endsection

