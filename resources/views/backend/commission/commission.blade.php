{{-- @extends('backend.layouts.app')
@section('title')
Commission
@endsection
@push('css')
<style>
    .disabled{
        display: none;
    }
    .disabled-1{
        display: none;
    }
</style>
@endpush --}}
{{-- @section('content')
<div class="container margin-bottom-cat">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-head">
                    <h4 class="text-center my-3">Category-Wise Commission</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('commission.calculate')}}" method="POST">
                        @csrf

                        <div class="control">
                            <div class="my-3">
                                <label class="radio">
                                    <input type="radio" name="fixed_amount" id="fixed_amount_offer" > Fixed Amount of Offer
                                </label>
                                <label class="radio">
                                    <input type="radio" name="percentage_amount" id="percentage_amount_offer" > Percentage Amount of Offer
                                </label>
                            </div>
                            <div>
                                <input type="text" class="disabled-1 form-control" id="fixed_amount" name="fixed_amount" placeholder="Enter your Fixed Commission">
                                <input type="text" class="disabled form-control" id="percentage_amount" name="percentage_amount" placeholder="Enter your Percentage Commission" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category Name</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach($category as $values)
                                    <option value="{{  $values->id }}">{{ $values->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="merchant_id">Merchant Area</label>
                                <select name="merchant_id" id="merchant_id" class="form-control my-2">
                                    <option value="">---Select Merchant---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="offer_id"><strong>Offer Title</strong></label>
                                <select name="offer_id" id="offer_id" class="form-control my-2">
                                    <option value="">---Select Module---</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <label for="name1">Admin Name</label>
                            <select name="admin_id" id="name1" class="form-control">
                                @foreach($admin as $value)
                                    <option value="{{  $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div><br>
                        <!-- Your form fields here -->
                        <button class="btn btn-danger" type="submit">Calculate Commission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
{{-- @push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#category_id').change(function () {
            var category_id = $(this).val();
            $.ajax({
                url: '/commission',
                type: 'post',
                dataType: 'json',
                data: 'category_id=' + category_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Handle the response
                    $('#merchant_id').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#merchant_id').change(function () {
            var offer_id = $(this).val();
            $.ajax({
                url: '/merchant',
                type: 'post',
                dataType: 'json',
                data: {offer_id:offer_id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    // Handle the response
                    $('#offer_id').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });

        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#fixed_amount_offer').click(function(){
            $('#fixed_amount').css("display", "block");
            $('#percentage_amount').hide();
        });
        $('#percentage_amount_offer').click(function(){
            $('#percentage_amount').css("display", "block");
            $('#fixed_amount').hide();
        });
    });
</script>
@endpush --}}
@extends('backend.layouts.app')
@section('title')
Category wise Pending List
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
                                            <a class="btn btn-info" href="{{route('showCommissionDetails',$qrCodes->id)}}">
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

