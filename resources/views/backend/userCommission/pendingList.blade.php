@extends('backend.layouts.app')
@section('title')
Pending List
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

			<div class="card border-offer">
				<div class="card-body">
					<div class="customer-card mb-3" style="margin-top:-10px;">
						<div class="area-h3">
							<h2>Pending List</h2> </div>
						<div class="print">
                            <a href="{{route('csv.customer')}}" class="btn btn-primary pdf">CSV</a>
                            <a href="{{route('excel.customer')}}" class="btn btn-primary pdf">Excel</a>
                            <a class="btn btn-primary pdf" href="{{route('pdf.customer')}}">PDF</a>
                            <a class="btn btn-primary pdf btnprn" href="" onclick="print()">Print</a>
                        </div>

                    </div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered" id="example">
								<thead>
									<tr>
									<th>
											<p style="width: max-content;"> Offer</p>
										</th>
										<th>
											<p style="width: max-content;">User</p>
										</th>

                                        <th>
											<p style="width: max-content;"> Qr Code </p>
										</th>
                                        <th>
											<p style="width: max-content;"> Receipt </p>
										</th>
										<th>
											<p style="width: max-content;">Fixed $</p>
										</th>
										<th>
											<p style="width: max-content;">%</p>
										</th>

										<th>
											<p style="width: max-content;">Status</p>
										</th>
										<th>
											<p style="width: max-content;">Actions</p>
										</th>
									</tr>
								</thead>
								<tbody>
									@foreach($physicallyApprove as $physicallyApproves)
									<tr>
										<td>{{$physicallyApproves['offer']['id'] ?? null}}</td>
										<td>{{$physicallyApproves['users']['phone'] ?? null}}</td>
                                        <td>{{$physicallyApproves->qr_code_id}}</td>
                                        <td>
                                            <img src="{{ asset($physicallyApproves->receipt) }}" style="width:100px;height:100px" alt="">
                                        </td>
                                        <td>{{$physicallyApproves->fixed_amount}}</td>
										<td>{{$physicallyApproves->percentage_amount}}</td>
										<td>
                                        @if($physicallyApproves->status == 'pending')
                                        <span class="btn btn-danger">Pending</span>
                                        @elseif($physicallyApproves->status == 'approved')
                                        <span class="btn btn-success">Approve</span>
                                        @endif
                                        <!-- <span class="btn btn-danger">{{ $physicallyApproves->status}}</span> -->
										</td>
										<td>
                                        <a class="btn btn-info" href="{{route('show.user.commission',$physicallyApproves->id)}}">
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
