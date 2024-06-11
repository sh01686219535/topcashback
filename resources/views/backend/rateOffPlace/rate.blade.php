@extends('backend.layouts.app')
@section('title')
Rate Off Place
@endsection
@section('content')
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
@endpush
<!-- Hoverable Table rows -->
<div class="contasiner offer-container">
    <div class="row margin-rate">
        <div class="col-lg-12">
            <!-- <div class="card mb-2">
                <div class="card-head mx-5 my-3 customer-card">
                    <a href="{{route('add.rate')}}" class="btn btn-primary" title="Add Role">Add Rate Off Place</a>
                    <div class="search">
                        <form action="" method="post" class="search-form">
                            @csrf
                            <input type="search" id="search" name="order_serch" placeholder="Search" class="form-control order-search">
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="card">
                <div class="card-body">
                <div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Rate Off Place List</h2> </div>
						<div class="print"> 
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a> 
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a> 
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a> 
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a> 
                        </div>
						<div class="btn-customer" style="margin-top:10px;">
                        <a href="{{route('add.rate')}}" class="btn btn-primary" title="Add Role"><i class="fa-solid fa-plus"></i> Add Rate Off Place</a>

						</div>
                        </div>
                    <table class="table table-hover table-borderd" id="example">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Place Name</th>
                                <th>Price</th>
                                <!-- <th>Merchant Area</th> -->
                                <!-- <th>Expiry Date</th> -->
                                <!-- <th>Created Date</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach($ratePlace as $ratePlaces)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$ratePlaces->placeName}}</td>
                                <td>{{$ratePlaces->ratePlace}}</td>
                               
                                <!-- <td>{{$ratePlaces->expiryDate}}</td> -->
                                <!-- <td>{{\carbon\carbon::create($ratePlaces->created_at)->format('d-M-y')}}</td> -->
                                <td>
                                    <a href="{{route('edit.rate',$ratePlaces->id)}}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{route('delete.rate',$ratePlaces->id)}}" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure delete this!')"><i class="fa-solid fa-trash"></i></a>
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
<!--/ Hoverable Table rows -->

@endsection
@push('js')
	<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
	<script>
	new DataTable('#example', {
		select: true
	});
	</script> 
@endpush