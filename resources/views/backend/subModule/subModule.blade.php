@extends('backend.layouts.app')
@section('title')
    Sub Module
@endsection
@section('content')
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
    <div class="container offer-container">
        <div class="row margin-offer">
            <div class="col-lg-12">
                <!-- <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <a href="{{route('add.subModule')}}" class="btn btn-primary" title="Add Role" ><i class="fa-solid fa-plus"></i> Add Sub Module</a>
                        <div class="search">
                            <form action="" method="post" class="search-form">
                                @csrf
                                <input type="search" id="search" name="order_serch" placeholder="Search"
                                       class="form-control order-search">
                            </form>
                        </div>
                    </div>
                </div> -->
                <div class="card">
                    <div class="card-body">
                    <div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Sub Module List</h2> </div>
						<div class="print">
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                        </div>
						<div class="btn-customer" style="margin-top:10px;">
                        <a href="{{route('add.subModule')}}" class="btn btn-primary" title="Add Role" ><i class="fa-solid fa-plus"></i> Add Sub Module</a>

						</div>
                        </div>
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                            <tr>
                                <th>SI</th>
                                <th>Module Name</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 1 @endphp
                            @foreach($subModule as $subModules)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$subModules['module']['module_name'] ??  null}}</td>
                                    <td>{{$subModules->subModule_name}}</td>
                                    <td>
                                        <a href="{{route('edit.subModule',$subModules->id)}}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{route('delete.subModule',$subModules->id)}}" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure delete this!')"><i class="fa-solid fa-trash"></i></a>
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




