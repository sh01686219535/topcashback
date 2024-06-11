@extends('backend.layouts.app')
@section('title')
Customer
@endsection
@section('content')
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
<style>
  @media only print {
         body {
            visibility: hidden;
         }
         .table {
            visibility: visible;
         }
      }

</style>
<!-- Hoverable Table rows -->
<div class="container customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- <div class="card-head customer-card m-5">
                    <h1 class="">Customer Table</h1>
                    <div class="search">
                        <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                        <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                        <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                        <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                        <form action="" method="post" class="search-form">
                            @csrf
                            <input type="search" id="search" name="order_serch" placeholder="Search"
                                class="form-control order-search">
                        </form>
                    </div>
                </div> -->
                <div class="card-body">
                <div class="customer-card mb-3" style="margin-top:-10px;">
                    <div class="area-h3">
                    <h2 >Customer Table</h2>
                    </div>
                    <div class="btn-customer" style="margin:10px 0 20px 0;">
                    <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                               <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                               <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                               <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                    </div>

                    <table class="table table-hover table-borderd" id="example">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php $i = 1 @endphp
                            @foreach($user as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item->name}}</>
                                </td>
                                <td>{{$item->phone}}</>
                                </td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('edit.customer',$item->id)}}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="{{route('delete.customer',$item->id)}}"
                                                id="delete"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--/ Hoverable Table rows -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
$(document).ready(function() {


});
function cssPrint() {

         print();
      }
</script>
@endsection
@push('js')
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
<script>
    new DataTable('#example', {
    select: true
    });
</script>
@endpush
