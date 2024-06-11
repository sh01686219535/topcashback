@extends('backend.layouts.app')
@section('title')
Approve Offer
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
							<h2>Approve Table</h2> </div>
						<div class="print">
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                        </div>
						<!-- <div class="btn-customer" style="margin-top:10px;">
                        <a href="{{route('add.offer')}}" class="btn btn-primary" title="Add Category"><i class="fa-solid fa-plus"></i> Add Offer</a>
                        </div> -->
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
										<th>
											<p style="width: max-content;">Offer</p>
										</th>
										<!-- <th>
											<p style="width: max-content;">Offer %</p>
										</th>
										<th>
											<p style="width: max-content;">Offern Amount</p>
										</th> -->
										<th>
											<p style="width: max-content;">Status</p>
										</th>
										<th>
											<p style="width: max-content;">Actions</p>
										</th>
									</tr>
								</thead>
								<tbody> @php $i = 1 @endphp @foreach($offer as $offers)
									<tr>
										<td>{{$offers->id}}</td>
										<td>{{$offers->category->category_name}}</td>
										<td>{{$offers->subCategory->sub_category_name}}</td>
										<td>{{$offers->id}}</td>
										<!-- <td>{{$offers->offer_percentage}}</td>
										<td>{{$offers->offer_amount}}</td>  -->
										<!-- <td> <img src="{{asset($offers->offer_image)}}" style="width:50px; height:50px;" alt=""> </td>
										<td> <img src="{{asset($offers->banner_image)}}" style="width:50px; height:50px;" alt=""> </td> -->
										<!-- <td>{{Str::limit($offers->offer_description,12)}}</td> -->
										<td>
                                        @if($offers->status == 'false')
                                        <span class="btn btn-danger">Pending</span>
                                        @elseif($offers->status == 'true')
                                        <span class="btn btn-success">Approve</span>
                                        @endif
                                        <!-- <span class="btn btn-danger">{{ $offers->status}}</span> -->
										</td>
										<td>
                                        <a class="btn btn-info" href="{{route('approve.edit.offer',$offers->id)}}">
                                        <i class="fa fa-eye"></i> Approve</a>

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
