@extends('backend.layouts.app')
@section('title')
Offer
@endsection
@section('content')
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

<!-- Hoverable Table rows -->
<div class="contasiner offer-container">
	<div class="row margin-offer">
		<div class="col-lg-12">
			<!-- <div class="card mb-3">
				<div class="card-head m-3 customer-card"> <a href="{{route('add.offer')}}" class="btn btn-primary" title="Add Category"><i class="fa-solid fa-plus"></i> Add Offer</a>
					<div class="search"> <a class="btn btn-primary pdf" href="{{route('pdf.product')}}">PDF</a>
						<form action="" method="post" class="search-form"> @csrf
							<input type="search" id="search" name="order_serch" placeholder="Search" class="form-control order-search"> </form>
					</div>
				</div>
			</div> -->
			<div class="card border-offer">
				<div class="card-body">
					<div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Offer Table</h2> </div>
						<div class="print">
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                        </div>
						<div class="btn-customer" style="margin-top:10px;">
                        <a href="{{route('add.offer')}}" class="btn btn-primary" title="Add Category"><i class="fa-solid fa-plus"></i> Add Offer</a>
                        </div>
                    </div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered" id="example">
								<thead>
									<tr>
										<th>Offer</th>
										<th>
											<p style="width: max-content;">Category</p>
										</th>
										<th>
											<p style="width: max-content;"> Sub Category </p>
										</th>
										{{-- <th>
											<p style="width: max-content;">Offer Title</p>
										</th> --}}
										<th>
											<p style="width: max-content;">%</p>
										</th>
										<th>
											<p style="width: max-content;">$</p>
										</th> {{--
										<th>Affiliate Link</th> --}}
										<th>
											<p style="width: max-content;">Image</p>
										</th>
										<th>
											<p style="width: max-content;">Banner</p>
										</th>
										 {{--
										<th>
											<p style="width: max-content;">Featured</p>
										</th> --}}
										<th>
											<p style="width: max-content;">Action</p>
										</th>
									</tr>
								</thead>
								<tbody> @php $i = 1 @endphp @foreach($offer as $offers)
									<tr>
										{{-- <td>{{$i++}}</td> --}}
                                        <td>{{Str::limit($offers->id,8)}}</td>
										<td>{{$offers->category->category_name}}</td>
										<td>{{$offers->subCategory->sub_category_name}}</td>

										<td>{{$offers->offer_percentage}}</td>
										<td>{{$offers->offer_amount}}</td> {{--
										<td>{{Str::limit($offers->affiliate_link,10)}}</td> --}}
										<td> <img src="{{asset($offers->offer_image)}}" style="width:50px; height:50px;" alt=""> </td>
										<td> <img src="{{asset($offers->banner_image)}}" style="width:50px; height:50px;" alt=""> </td>
										 {{--
										<td>
											<div class="form-check text-center  ">
												<input class="form-check-input" type="checkbox" {{ $offers->status === 'true' ? 'checked' : '' }}> </div>
										</td> --}}
										<td>
											<div class="dropdown">
												<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"> <i class="bx bx-dots-vertical-rounded"></i> </button>
												<div class="dropdown-menu"> <a class="dropdown-item" href="{{route('edit.offer',$offers->id)}}"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a> <a class="dropdown-item" href="{{route('delete.offer',$offers->id)}}" onclick="return confirm('Are you sure delete this!')"><i class="bx bx-trash me-1"></i> Delete</a> </div>
											</div>
										</td>
									</tr> @endforeach </tbody>
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
