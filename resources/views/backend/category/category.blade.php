@extends('backend.layouts.app') 
@section('title') 
Category 
@endsection 
@section('content') 
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
@endpush
<!-- Hoverable Table rows -->
<div class="contasiner customer-container">
	<div class="row">
		<div class="col-lg-12">
			<!-- <div class="card mb-2">
                <div class="card-head mx-5 my-3 customer-card">
                    <a href="" class="btn btn-primary" title="Add Category" data-bs-toggle="modal"
                        data-bs-target="#categoryModal"><i class="fa-solid fa-plus"></i> Add Category</a>
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
            </div> -->
			<div class="card">
				<div class="card-body">
					<div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Category Table</h2> </div>
						<div class="print"> 
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a> 
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                             <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a> 
                             <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a> 
                            </div>
						<div class="btn-customer" style="margin-top:10px;"> 
                        <a href="" class="btn btn-primary" title="Add Category" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class="fa-solid fa-plus"></i> Add Category</a> </div>
                    </div>
						<table class="table table-hover table-borderd" id="example">
							<thead>
								<tr>
									<th>SI</th>
									<th>Category Name</th> {{--
									<th>Merchant Area</th> --}}
									<th>Actions</th>
								</tr>
							</thead>
							<tbody> @php $i = 1 @endphp @foreach($category as $categories)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$categories->category_name}}</td>
									<td>
										<!-- <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{route('edit.category',$categories->id)}}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="{{route('delete.category',$categories->id)}}"
                                                onclick="return confirm('Are you sure delete this!')"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div> --><a href="{{route('edit.category',$categories->id)}}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a> <a href="{{route('delete.category',$categories->id)}}" title="Delete" class="btn btn-danger" id="delete"><i class="fa-solid fa-trash"></i></a> </td>
								</tr> @endforeach </tbody>
						</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!--/ Hoverable Table rows -->
@include('backend.category.categoryAddModal') 
@endsection 
@push('js')
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
<script>
new DataTable('#example', {
	select: true
});
</script> 
@endpush