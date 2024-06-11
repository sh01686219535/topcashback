@extends('backend.layouts.app')
@section('title')
    Currency List
@endsection
@section('content')
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
@endpush
    <div class="container offer-container">
        <div class="row margin-rate">
            <div class="col-lg-12">
                <!-- <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Currency List</h3>
                        </div>
                        <div class="search">
                            <a href="{{ route('add.currency') }}" class="btn btn-primary" title="Add Category">
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Add Currency</a>
                        </div>
                    </div>
                </div> -->
                @include('error')
                <div class="card">
                    <div class="card-body">
                    <div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Currency List</h2> </div>
						<div class="print"> 
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a> 
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a> 
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a> 
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a> 
                        </div>
						<div class="btn-customer" style="margin-top:10px;">
                        <a href="{{ route('add.currency') }}" class="btn btn-primary" title="Add Currency" ><i class="fa-solid fa-plus"></i> Add Currency</a>

						</div>
                        </div>
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                            <tr>
                                <th>SI</th>
                                <th>Name</th>
                                <th>Symbol</th>
                                <th>Code</th>
                                <th>Exchange Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($currency as $key => $lists)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lists->name }}</td>
                                <td>{{ $lists->symbol }}</td>
                                <td>{{ $lists->code }}</td>
                                <td>{{ $lists->exchange_rate }}</td>
                                <td>{{ $lists->status }}</td>
                                <td>
                                    <a href="{{ route('edit.currency',$lists->id) }}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{ route('delete.currency',$lists->id) }}" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure delete this!')"><i class="fa-solid fa-trash"></i></a>
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
@endsection
@push('js')
	<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
	<script>
	new DataTable('#example', {
		select: true
	});
	</script> 
@endpush




