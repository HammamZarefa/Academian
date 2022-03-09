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
               <div id="paypal-button-container"></div>
               <div class="text-center" id="loading">Please wait ...</div>              
            </div>
         </div>
      </div>
   </div>
   <form id="payment-form" method="POST" action="{{ route('paypal_checkout_process') }}">
      @csrf
      <input id="order_id" name="order_id" type="hidden" />
   </form>
</div>

@endsection

@push('scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{ $data['client_id'] }}&currency={{ $data['currency'] }}"></script>

<script>

 document.addEventListener("DOMContentLoaded", function(event) {

if(window.hasOwnProperty("paypal")){
  paypal.Buttons({
    createOrder: function (data, actions) {

       return axios.post("{{ route('paypal_checkout_generate_token') }}")
            .then(function(response) {
              if(response.data.status == 'success')
              {
                return response.data.id;
              }            
            return null;
          });
    },
    onApprove: function(data, actions) {
      if(data.orderID)
      {  
         $('#paypal-button-container').hide();
         $('#loading').show();
         var form = document.querySelector('#payment-form');
         document.querySelector('#order_id').value = data.orderID;
         form.submit();
      }       

    },
    onDisplay:function(){
      $("#loading").hide();
    },  
    onError: function (err) {      
      $('#paypal-button-container').show();
      $('#loading').hide();
      showError("Something went wrong, please try again later, or use a different payment method");
    }
  }).render('#paypal-button-container');
  
} else {

   showError("Something went wrong, please try again later, or use a different payment method");
   $('#loading').hide();
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


    }); // End of script


   
</script>
@endpush