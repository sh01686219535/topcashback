<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    
<div class="container">
    
    <h1 class="text-center" style="margin-top:30px">Payment Details</h1>
    
    <div class="row">
        @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('verification.payment',$qrCode->id) }}" 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-7" style="display:none">
                            <div class="form-group col-md-6 ">
                               <label for="">User Name</label>
                              <input type="text" value="{{$user_id}}" name="user_id" class="form-control my-2">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="">Merchant Name</label>
                                <select name="merchant_id" class="form-control my-2">
                                    @foreach ($merchant as $item)
                                    <option value="{{$item->id}}" {{$item->id == $qrCode->merchant_id ? 'selected' : ''}}>{{$item->areas->areaName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="">Qr Code</label>
                                <input type="text" value="{{ $qr_code }}" name="qr_code_id" class="form-control my-2">
                             </div>
                             @if ($fixed_amount)
                             <div class="form-group col-md-6 ">
                                <label for="">Fixed Amount</label>
                                 <input type="text" value="{{$fixed_amount}}" name="fixed_amount" class="form-control my-2">
                              </div>
                             @else
                             <div class="form-group col-md-6">
                                <label for="">Percentage Amount</label>
                                <input type="text" name="percentage_amount" value="{{$percentage_amount}}" class="form-control" >
                             </div>
                             @endif
                             <div class="form-group col-md-6">
                                <label for="">Offer</label>
                                <input type="text" name="offer_id" value="{{$offer_id}}" class="form-control" >
                             </div>
                             <div class="form-group col-md-6">
                                <label for="">Purchase Amount</label>
                                <input type="text" class="form-control" name="purchase_amount" value="{{$purchase_amount}}" >
                             </div>
                             <div class="form-group col-md-6">
                                <label for="">Receipt</label>
                                <input type="file" class="form-control my-2" name="receipt" id="receipt" >
                                <img src="" alt="" id="image">
                             </div>
                        </div>
                          <div class="col-md-5" style="margin:30px 0 0 340px;">
                        <div class="panel panel-default credit-card-box">
                      <div class="panel-heading display-table" >
                        <h3 class="panel-title" >Please Enter Your Card Details</h3>
                      </div>
                       <div class="panel-body">
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
    
                        <div class="row">
                          
                        </div>
                        <div class="col-xs-12">
                            @if ($fixed_amount)
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now (${{$fixed_amount}})</button>
                            @else
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now (${{$percentage_amount}})</button>
                            @endif
                        </div>
                </div>
            </div>        
        </div>
    </form>
    </div>
        
</div>
    
</body>
    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
<script>
    
    // let img = document.getElementById('receipt');
    // img.src = localStorage.getItem('image');
</script>
<script type="text/javascript">
  
$(function() {
   
    let img = document.getElementById('image');
    $('#receipt').val(img.src);
    console.log(img);
    img.src = localStorage.getItem('image');
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
</html>
