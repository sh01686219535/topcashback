@extends('backend.layouts.app')
@section('title')
Footer Menu
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
                    <a href="{{ route('showFooter_details') }}" class="btn btn-primary" title="Add Category" d><i class="fa-solid fa-plus"></i> Add Footer Menu</a>
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
							<h2>Footer Details List</h2> </div>
						<div class="print"> 
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a> 
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a> 
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a> 
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a> 
                        </div>
						<div class="btn-customer" style="margin-top:10px;"> 
                        <a href="{{ route('showFooter_details') }}" class="btn btn-primary" title="Add Footer Menu">
                            <i class="fa-solid fa-plus"></i> Footer Menu</a> 
                        </div>
					</div>
                    <table class="table table-hover table-borderd example">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th style="width: 20%">Title</th>
                                <th style="width: 20%">Image</th>
                                <th style="width: 20%">Description</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                          @foreach($footerDetails as $footerDetail)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $footerDetail->title}}</td>
                                <td>
                                    <img src="{{ asset('admin/assets/footer_details/' . $footerDetail->image) }}" class="slideImg" alt="">
                                </td>
                                <td>{!! html_entity_decode($footerDetail->description, ENT_QUOTES, 'UTF-8') !!}</td>
                                <!-- <td>{!!htmlspecialchars($footerDetail->description)!!}</td> -->
                                <td>
                                    <a href="{{route('edit.footer_details',$footerDetail->id)}}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{route('delete.footer_details',$footerDetail->id)}}" id="delete" title="Delete" class="btn btn-danger" id="delete"><i class="fa-solid fa-trash"></i></a>
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
	new DataTable('.example', {
		select: true
	});
	</script> 
@endpush

