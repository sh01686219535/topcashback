@extends('backend.layouts.app')



@section('title')
    Merchant
@endsection
@section('content')
<!-- Modal -->
<div class="contasiner customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-head  m-5">
        <form action="{{route('edit.category',$category->id)}}" method="post" id="newModalForm">
            @csrf

            <div class="modal-content">
            @include('error')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Category Edit Page</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label for="company_name">Company Name</label>
                       <select class="form-control" name="merchant_id" id="company_name">
                        @foreach ($merchant as $merchants)
                        <option value="{{ $merchants->id }}"{{ $merchants->id == $category->merchant_id ? 'selected' : ''}}>{{ $merchants->company_name }}</option>
                        @endforeach
                       </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" id="category_name" name="category_name" placeholder="Category Name" value="{{ $category->category_name }}"
                            class="form-control my-2" required>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

@endsection

