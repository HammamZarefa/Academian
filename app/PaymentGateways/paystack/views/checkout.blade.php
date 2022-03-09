@extends('layouts.app')
@section('title', 'Pay with '. $data['gateway_name'])
@section('content')
<div class="container page-container">
  <div class="row">
    <div class="col-md-12">
      <h3>Pay with {{ $data['gateway_name'] }}</h3>
      <hr>
    </div>
    <div class="col-md-6 d-none d-lg-block">
      <div class="checkout-image-cover">
        <img src="{{ asset('images/payment.svg') }}" class="img-fluid">
      </div>
    </div>
    <div class="col-md-6">
      @include('checkout.back_to_payment_options')
      <div class="card">
        <div class="card-body">        
          <div class="d-flex justify-content-between">            
            <h4 class="h4">Total</h4>
            <div class="h4">{{ format_money($data['total']) }}</div>
          </div>
          <hr>
          <form id='payment-form' style="display: none;">
            <div class="mb-3">
              <label for="card-element">Credit or debit card</label>
              <div id="card-element"></div>
              <div id="card-errors" class="invalid-feedback d-block"></div>
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block confirm-button" disabled><i class="fas fa-shopping-cart"></i> Confirm Payment</button>
          </form>
         <!--  <div class="text-center" id="loading">Please wait ...</div> -->
       
          <button class="btn btn-success btn-block" type="submit" id="payButton"><i class="fas fa-shopping-cart"></i> Pay Now</button>
       
        </div>
      </div>
    </div>
  </div>
  <div id="publishable_key" data-public_key="{{ $data['public_key'] }}"></div>
 <div id="verify_url" data-processurl="{{ route('paystack_verify_payment') }}"></div>

</div>
@endsection

@push('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>

$(function(){
  $('#payButton').on('click', payWithPaystack);
});

  function payWithPaystack() {
    

    var public_key = document.getElementById('publishable_key').dataset.public_key;
    var verify_url = document.getElementById('verify_url').dataset.processurl;

    // document.getElementById('payment-form').style.display = "block";
    // document.getElementById('loading').style.display = "none";

    
    var handler = PaystackPop.setup({
      key: public_key, // Replace with your public key  
      email: '{{ $data["email"] }}',
      amount: {{ $data["payment_amount"] }}, 
      currency: '{{ $data["currency"] }}', 
      firstname: '{{ $data["first_name"] }}',
      lastname: '{{ $data["last_name"] }}',

      // reference: 'YOUR_REFERENCE', // Replace with a reference you generated
      callback: function(response) {
        //this happens after the payment is completed successfully
        var reference = response.reference;

        verifyPayment(verify_url, reference);
       
        // Make an AJAX call to your server with the reference to verify the transaction
      },
      onClose: function() {
        showError('Transaction was not completed');
      },
    });
    handler.openIframe();


  }

  function verifyPayment(verify_url, reference){
    
    axios.post(verify_url, {reference: reference})
        .then(function (response) {
          var response = response.data;

          if(response.success)
          {
            window.location.href = response.redirect_url;
          }
          else
          {
            showError(response.message);
          }

        })
        .catch(function (error) {     
          showError('Something went wrong! Please try again later');
          console.log(error);
        });

  }

  function showError(message) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      });

      swalWithBootstrapButtons.fire({
        text: message
      });
    }

</script>
@endpush