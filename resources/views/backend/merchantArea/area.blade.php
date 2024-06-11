@extends('backend.layouts.app') 
@section('title') 
Area 
@endsection 
@section('content') 
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
@endpush
<div class="contasiner customer-container">
	<div class="row" style="margin-bottom:200px">
		<div class="col-lg-12">
			<!-- <div class="card mb-1">
                    <div class="card-head mx-5 my-3 customer-card">
                        <a href="{{route('add.area')}}" class="btn btn-primary" title="Add Role" >Add Area</a>
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
							<h3>Merchant Area</h3> </div>
						<div class="btn-customer" style="margin-top:10px;"> <a href="{{route('add.area')}}" class="btn btn-primary" title="Add Role"><i class="fa-solid fa-plus"></i>Add Area</a> </div>
					</div>
					<table class="table table-hover table-borderd" id="example">
						<thead>
							<tr>
								<th>SI</th>
								<th style="width:40%">Area Name</th>
								<th style="width:40%">Actions</th>
							</tr>
						</thead>
						<tbody> @php $i = 1 @endphp @foreach($area as $item)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$item->areaName}}</td>
								<td> <a href="{{route('edit.area',$item->id)}}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a> <a href="{{route('delete.area',$item->id)}}" title="Delete" class="btn btn-danger" id="delete"><i class="fa-solid fa-trash"></i></a> </td>
							</tr> @endforeach </tbody>
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