@extends('backend.layouts.app')
@section('title')
Merchant wise Pending List
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
							<h2>Online Pending List</h2> </div>
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
											<p style="width: max-content;">Offer</p>
										</th>
										<th>
											<p style="width: max-content;">Merchant</p>
										</th>

										<th>
											<p style="width: max-content;">$</p>
										</th>
                                        <th>
											<p style="width: max-content;">Qr Code</p>
										</th>
										<th>
											<p style="width: max-content;">%</p>
										</th>
                                        <th>
											<p style="width: max-content;">Created_At</p>
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
                                    @foreach ($qrCode as $key => $qrCodes)
                                    <tr>
                                        <td>{{ $qrCodes->offer->id }}</td>
                                        <td>{{ $qrCodes->merchant->merchant_name ?? null}}</td>

                                        <td>{{ $qrCodes->offer_amount }}</td>
                                        <td>{{ $qrCodes->qr_code }}</td>
                                        <td>{{ $qrCodes->percentage_amount }}</td>
                                        <td>{{ $qrCodes->created_at }}</td>
                                        <td>
                                            @if($qrCodes->status == 'pending')
                                            <span class="btn btn-danger">Pending</span>
                                            @elseif($qrCodes->status == 'approved')
                                            <span class="btn btn-success">Approve</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="{{route('show.merchant_wise.commission',$qrCodes->id)}}">
                                                <i class="fa fa-eye"></i> Process</a>
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
