@extends('layouts.app')
@section('title', 'Select a payment method')
@section('content')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<div class="container page-container pay-contain">
   <div class="row">
      <div class="col-md-12">
         <h5 class="card-title">
         @lang('Step')
         <b>3 </b>@lang('Of')
         <span class="small">3</span>
         </h5>
         <h6>@lang('Select a payment method')</h6>
      </div>
      <div class="col-md-6">
         <div class="card-pay">
            <div class="">
               <div class="d-flex justify-content-between discount" style="display: none">
                  <input name="discount" id="discount" disabled="disabled">
               </div>
               <div class="d-flex justify-content-between total">
                  <h4 class="h4">@lang('Total')</h4>
                  <div class="h4">{{ format_money($data['total']) }}</div>
                  <input hidden name="total" value="{{$data['total']}}">
               </div>
               @if(isset($data['order_number']) && isset($data['order_link']))
               <small class="order_number pad20">Your order number is : <a href="{{ $data['order_link'] }}">{{ $data['order_number'] }}</a></small>
               @endif
               @if(isset($data['payment_options']['online']))
                <hr>
                  <div class="pay-list">
                  <p class="pad20">@lang('Online:')</p>
                  @foreach($data['payment_options']['online'] as $option)
                    <a href="{{ $option->url }}" class="pay-item ">
                       {{ $option->name }}
                    </a>
                  @endforeach
                  </div>
               @endif
               <hr>

               @if(isset($data['payment_options']['offline']))
                  <br>
                  <p class="text-muted">@lang('Offline')</p>
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
               <p class=" pad20">@lang('Wallet- Balance'): {{ format_money(auth()->user()->wallet()->balance()) }}</p>
                  <div class="pay-list">
                  <a href="{{ route('pay_with_wallet') }}" class="pay-item pad20">
                        <div><i class="fas fa-wallet"></i>@lang('Pay using your wallet') </div>
                     </a>
                  </div>
               @endif

            </div>
         </div>
      <div class="mt-4" >
         <form id="coupon-form" data-token="{{ csrf_token() }}">
            <label class="coupon" style="font-weight: bold;margin-inline-start: 5px;"> @lang('Have Coupon?')</label>
            <input class="coupon-input" name="code" id="code" placeholder="your coupon code" >
            <button class="btn-Quest coupon-btn" id="check-coupon">Submit</button>
         </form>
      </div>
      </div>

   
      <div class="col-md-6 d-none d-lg-block">
         <div class="checkout-image-cover">
            <img src="{{ asset('images/payment.svg') }}" class="img-fluid">
         </div>
      </div>
   </div>

</div>

@endsection
{{--@push('script')--}}
{{--<script>--}}
        {{--$(".check-coupon").click(function(e){--}}
        {{--let name = $("input[name=code]").val();--}}
        {{--let _token   = $('meta[name="csrf-token"]').attr('content');--}}
        {{--$.ajax({--}}
            {{--url: "/check-validity",--}}
            {{--type:"POST",--}}
            {{--data:{--}}
                {{--name:name,--}}
                {{--_token: _token--}}
            {{--},--}}
            {{--success:function(response){--}}
                {{--console.log(response);--}}
                {{--if(response) {--}}
                    {{--$('.success').text(response.success);--}}
                    {{--$("#coupon")[0].reset();--}}
                {{--}--}}
            {{--},--}}
            {{--error: function(error) {--}}
                {{--console.log(error);--}}
                {{--// $('#nameError').text(response.responseJSON.errors.name);--}}
                {{--// $('#emailError').text(response.responseJSON.errors.email);--}}
                {{--// $('#mobileError').text(response.responseJSON.errors.mobile);--}}
                {{--// $('#messageError').text(response.responseJSON.errors.message);--}}
            {{--}--}}
        {{--});--}}
            {{--e.preventDefault();--}}
    {{--});--}}
{{--</script>--}}
{{--@endpush--}}