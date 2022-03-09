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
        
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection

@push('scripts')

@if(strtolower($data['environment']) == 'sandbox')
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
color="e34524" bolt-logo="{{ get_company_logo() }}"></script>
@else  
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="{{ get_company_logo() }}"></script>
@endif
<script type="text/javascript">
  function launchBOLT()
  {
    bolt.launch({
    key: "{{ $data['rec']->key }}",
    txnid: "{{ $data['rec']->txnid }}",
    hash: "{{ $data['hash'] }}",
    amount: "{{ $data['rec']->amount }}",
    firstname: "{{ $data['rec']->fname }}",
    email: "{{ $data['rec']->email }}",
    phone: "{{ $data['rec']->phone }}",
    productinfo: "{{ $data['rec']->pinfo }}",
    udf5: "{{ $data['rec']->udf5 }}",
    surl : "{{ $data['rec']->surl }}",
    furl: "{{ $data['rec']->furl }}",
    mode: 'dropout'	
  },{ responseHandler: function(BOLT){
 	
    
    
  },
    catchException: function(BOLT){
    
    }
  });
  }
 
  document.addEventListener("DOMContentLoaded", function(event) {

  launchBOLT();
 });
  </script>	
@endpush