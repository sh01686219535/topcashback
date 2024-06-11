@extends('backend.layouts.app')
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
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="customer-card card-head mx-5 mt-5 mb-3" style="margin-top:-10px;">
                    <div class="area-h3">
                        <h2>User commission</h2> </div>
                    <div class="print">
                        <a href="{{route('show.list.commission')}}" class="btn btn-primary pdf">User commission List</a>
                    </div>

                </div>
                    <div class="card-body">
                        <form action="{{ route('userCommissionStore',$physicallyApprove->id)}}" method="POST">
                            @csrf
                            <div class="control">
                                <div class="form-check form-check-inline my-2">
                                    <input class="form-check-input" type="radio" name="fixed_amount" id="fixed_amount_offer">
                                    Fixed Amount of Offer
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                                <div class="form-check form-check-inline my-2">
                                    <input class="form-check-input" type="radio" name="percentage_amount" id="percentage_amount_offer" >
                                    Percentage Amount of Offer
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                                <div>

                                    <input type="text" class="disabled-1 form-control" id="fixed_amount" name="fixed_amount" placeholder="Enter your Fixed Commission">
                                    <input type="text" class="disabled form-control" id="percentage_amount" name="percentage_amount" placeholder="Enter your Percentage Commission" >
                                </div>
                            </div>
                              
                                <div class="form-group">
                                    <label for="user_name">User Name</label>
                                    <input type="text" class="form-control my-2" value="{{ $physicallyApprove['users']['phone'] ?? null }}" id="user_name_1" name="user_id" >
                                </div>
                                <div class="form-group">
                                    <label for="offer_title">Offer Name</label>
                                    <!-- <select name="offer_title_id" id="offer_title" class="form-control my-2">
                                    @foreach($offer as $item)   
                                            <option value="{{$item->id}}" {{ $item->id ==  $physicallyApprove->offer_id ? 'selected' :  ''}}>{{ $item->offer_title }}</option>        
                                    @endforeach

                                    </select> -->
                                    <input type="text" class="form-control my-2" value="{{ $physicallyApprove['offer']['offer_title'] ?? null }}" id="offer_title_1" name="offer_title_id" >
                                </div>

                                @if($physicallyApprove->fixed_amount)
                                <div class="form-group">
                                    <label for="fixed_amount">Fixed Amount</label>
                                    <input type="text" class="form-control my-2" value="{{ $physicallyApprove->fixed_amount }}" id="fixed_amount_1" name="fixed_amount_1" >
                                </div>
                                @elseif($physicallyApprove->percentage_amount)
                                <div class="form-group">
                                    <label for="percentage_amount">Percentage Amount</label>
                                    <input type="text" class="form-control my-2" id="percentage_amount" name="percentage_amount_1" value="{{ $physicallyApprove->percentage_amount }}"   >

                                </div><br>
                                @endif
                                <!-- Your form fields here -->
                                <button class="btn btn-danger" type="submit">Calculate Commission</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>

        // $(document).ready(function() {
        //     $('.select3').select3();
        // });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // radio button change by cliking
      $(document).ready(function(){
         $('#fixed_amount_offer').click(function(){
             $('#fixed_amount').css("display", "block");
             $('#percentage_amount').hide();
             $("#percentage_amount_offer").prop( "checked", false );
             $(this).prop( "checked", true );
         });
         $('#percentage_amount_offer').click(function(){
             $('#percentage_amount').css("display", "block");
             $('#fixed_amount').hide();
             $("#fixed_amount_offer").prop( "checked", false );
             $(this).prop( "checked", true );
         });
     });

        $(document).ready(function () {
            $('#user_name_1').change(function () {
                var user_name_1 = $(this).val();
                $.ajax({
                    url: '/offer',
                    type:'post',
                    data:{user_name_1:user_name_1},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data){
                        $('#offer_title_1').html(data);
                    },
                    error:(error)=>{
                        console.log(error);
                    }
                });
            });
        });

        //fixed amount
        $(document).ready(function () {
            $('#offer_title_1').change(function () {
                var offer_title_id = $(this).val();
                // console.log(offer_title_id);
                $.ajax({
                    url: '/fixed_amount',
                    type:'post',
                    data:{offer_title_id:offer_title_id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data){
                        $('#fixed_amount_1').html(data);
                    },
                    error:(error)=>{
                        console.log(error);
                    }
                });
            });
        });
        //Percentage amount
        $(document).ready(function () {
            $('#offer_title_1').change(function () {
                var offer_title = $(this).val();
                $.ajax({
                    url: '/percentage_amount',
                    type:'post',
                    data:{offer_title:offer_title},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data){
                        $('#percentage_amount-1').html(data);
                    },
                    error:(error)=>{
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
