@extends('layouts.app')
@section('title', 'Select a payment method')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h3>Select a payment method</h3>        
         <hr>
      </div>
      <div class="col-md-6 d-none d-lg-block">
         <div class="checkout-image-cover">
            <img src="{{ asset('images/payment.svg') }}" class="img-fluid">   
         </div>
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                  <h4 class="h4">Total</h4>
                  <div class="h4">{{ format_money($data['total']) }}</div>
               </div>
               @if(isset($data['order_number']) && isset($data['order_link']))
                  <small>Your order number is : <a href="{{ $data['order_link'] }}">{{ $data['order_number'] }}</a></small>
               @endif
               <hr>               
               @if(isset($data['payment_options']['online']))  
                  <p class="text-muted">Online</p>              
                  <div class="list-group">
                  @foreach($data['payment_options']['online'] as $option)
                    <a href="{{ $option->url }}" class="list-group-item list-group-item-action">
                       {{ $option->name }}
                    </a>
                  @endforeach
                  </div>
               @endif

                     
               @if(isset($data['payment_options']['offline']))   
                  <br>   
                  <p class="text-muted">Offline</p>                       
                  <div class="list-group">
                  @foreach($data['payment_options']['offline'] as $option)
                    <a href="{{ route('pay_with_offline_method', $option->slug) }}" class="list-group-item list-group-item-action">
                       <div>{{ $option->name }}</div>
                       <small class="text-muted">{{ $option->description }}</small>
                    </a>
                  @endforeach
                  </div>
               @endif
               @if($data['show_wallet_option'])   
               <br>   
               <p class="text-muted">Wallet- Balance: {{ format_money(auth()->user()->wallet()->balance()) }}</p>   
                  <div class="list-group">
                  <a href="{{ route('pay_with_wallet') }}" class="list-group-item list-group-item-action">
                        <div><i class="fas fa-wallet"></i> Pay using your wallet</div>                        
                     </a>
                  </div> 
               @endif   

            </div>
         </div>
      </div>
   </div>
   
</div>

@endsection