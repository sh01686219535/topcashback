@extends('backend.layouts.app')
@section('title')
List
@endsection
@section('content')

<!-- Hoverable Table rows -->
<div class="contasiner customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-head m-5 customer-card">
                    {{-- <a href="" class="btn btn-primary" title="Add Category" data-bs-toggle="modal"
                        data-bs-target="#categoryModal">Add Category</a> --}}
                    <div class="search">
                        <a href="" class="btn btn-primary pdf">Excel</a>
                        <a class="btn btn-primary pdf" href="{{route('pdf.category')}}">PDF</a>
                        <form action="" method="post" class="search-form">
                            @csrf
                            <input type="search" id="search" name="order_serch" placeholder="Search"
                                class="form-control order-search">
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-header text-center">Advertisement List</h3>
                    <table class="table table-hover table-borderd">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Merchant Area</th>
                                <th>Created Date</th>
                                <th>Expiry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach($advertisement as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item['rateOffModel']['placeName']}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item['merchant']['area'] }}</td>
                                <td>
                                    <a href="{{}}" class="btn btn-primary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{}" class="btn btn-primary" title="Delete"><i class="fa-solid fa-pen-to-delete"></i></a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $category->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Hoverable Table rows -->

@endsection
