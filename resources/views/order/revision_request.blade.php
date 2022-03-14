@extends('layouts.app')
@section('title', 'Request for revision - '. $order->number )
@section('content')
<div class="container public-page-container">
   <div class="row">
      <div class="col-md-6">
         <h3>@lang('Request for revision') : {{ $order->number }} </h3>
      </div>
      <div class="col-md-6">
         <h5 class="float-md-right">@lang('Status'): <span class="badge {{ $order->status->badge }}">{{ $order->status->name }}</span></h5>
      </div>
      <div class="col-md-12"><hr></div>

      <div class="col-md-6">
         <form action="{{ route('post_revision_request', $order->id) }}" method="POST" autocomplete="off">
            {{ csrf_field()  }}
            <label>@lang('Your Message')</label>
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <textarea class="form-control {{ showErrorClass($errors, 'message') }}" name="message"></textarea>
            <div class="invalid-feedback d-block">{{ showError($errors, 'message') }}</div>
            <br>
            <button class="btn btn-success" type="submit" name="submit">@lang('&nbsp &nbsp &nbsp &nbsp Submit &nbsp &nbsp &nbsp &nbsp')</button>
         </form>
      </div>
   </div>
</div>
@endsection
