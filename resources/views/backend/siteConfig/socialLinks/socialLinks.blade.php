@extends('backend.layouts.app')
@section('title')
    Social List
@endsection
@section('content')
@push('css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
@endpush
    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Social List</h3>
                        </div>
                        <div class="search">
                            <a href="{{ route('addSocialLinks') }}" class="btn btn-primary" title="Add Category">
                            <i class="fa-solid fa-plus"></i>
                                Create Social</a>
                        </div>
                    </div>
                </div> -->
                @include('error')
                <div class="card">
                    <div class="card-body">
                    <div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Social List</h2> </div>
						<div class="print"> 
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a> 
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a> 
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a> 
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a> 
                        </div>
						<div class="btn-customer" style="margin-top:10px;">
                        <a href="{{ route('addSocialLinks') }}" class="btn btn-primary" title="Add Social" ><i class="fa-solid fa-plus"></i> Create Social</a>

						</div>
                        </div>
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                            <tr>
                                <th>SI</th>
                                <th>Name</th>
                                <th>logo</th>
                                <th>Social Links</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- @php $i = 1 @endphp
                            @foreach($module as $modules) --}}
                            @foreach($social_links as $key => $social_link)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $social_link->social_name }}</td>
                                {{-- <td>{{ $social_link->social_logo }}</td> --}}
                                <td>{{ $social_link->social_links }}</td>
                                <td>
                                    <img height="100px" width="100px" src="{{ asset('admin/assets/social_icons/' . $social_link->social_logo) }}"  alt="">
                                </td>
                                <td>
                                    <a href="{{ route('showEditSocialLinks',$social_link->id) }}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{ route('showDeleteSocialLinks',$social_link->id) }}" title="Delete" class="btn btn-danger" id="delete"><i class="fa-solid fa-trash"></i></a>
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






