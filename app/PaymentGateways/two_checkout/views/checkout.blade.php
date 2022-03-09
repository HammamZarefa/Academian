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
          <form type="post" id="payment-form">
            <div id="card-element">
              <!-- A TCO IFRAME will be inserted here. -->
            </div>

            <button class="btn btn-primary" type="submit">Generate token</button>
          </form>
          <div class="text-center" id="loading">Please wait ...</div>
        </div>
      </div>
    </div>
  </div>



</div>
@endsection

@push('scripts')

<script type="text/javascript" src="https://2pay-js.2checkout.com/v1/2pay.js"></script>
<script>

window.addEventListener('load', function() {
  // Initialize the 2Pay.js client.
  let jsPaymentClient = new TwoPayClient("{{ $data['merchant_code'] }}");
  
  // Create the component that will hold the card fields.
  let component = jsPaymentClient.components.create('card');
  
  // Mount the card fields component in the desired HTML tag. This is where the iframe will be located.
  component.mount('#card-element');

  // Handle form submission.
  document.getElementById('payment-form').addEventListener('submit', (event) => {
    event.preventDefault();
    
    // Extract the Name field value
    const billingDetails = {
      name: "{{ $data['customer_name'] }}"
    };

    // Call the generate method using the component as the first parameter
    // and the billing details as the second one
    jsPaymentClient.tokens.generate(component, billingDetails).then((response) => {
  
      var token = response.token;
      $("#loading").show();
        axios.post("{{ route('two_checkout_process') }}", {
          token: token,
          })
          .then(function(response) {
            console.log(response);
            
            
          })
          .catch(function(error) {
            console.log(error);
            
          });


    }).catch((error) => {
      console.error(error);
    });
  });
});

    function disableConfirmButton() {
      document.getElementsByClassName('confirm-button')[0].disabled = true;
    }

    function enableConfirmButton() {
      document.getElementsByClassName('confirm-button')[0].disabled = false;
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


  // End of script
</script>
@endpush