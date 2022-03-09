@extends('layouts.app')
@section('title', 'Request for payment')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>Request for payment</h4>
         <hr>
      </div>
      @if($unbilled_tasks->count() > 0)      
      <div class="col-md-7">         

         <table id="payment_request_table" class="table">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Item</th>
                  <th class="text-right">Amount</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($unbilled_tasks as $key=>$order)
               <tr>
                  <th>{{ $key + 1 }}</th>
                  <td><a href="{{ route('orders_show', $order->id) }}">{{ $order->number }}</a></td>
                  <td class="text-right">{{ format_money($order->staff_payment_amount) }}</td>
               </tr>
               @endforeach               
            </tbody>
            <tfoot>
               <tr>
                  <th></th>
                  <th>Total</a></th>
                  <th class="text-right">{{ format_money($data['total']) }}</th>
               </tr>
            </tfoot>
         </table>
      </div>
      <div class="offset-md-1 col-md-4">
            <div class="card">
      <div class="card-header">Submit Payout Request
      </div>
      <div class="card-body">
     
         
            <form action="{{ route('post_request_for_payment') }}" method="POST" autocomplete="off">
               {{ csrf_field()  }}    
                         
               <div class="form-group">
                  <label>Your Name <span class="required">*</span></label>
                  <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', auth()->user()->full_name) }}"> 
                  <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
               </div>
               <div class="form-group">
                  <label>Your Address <span class="required">*</span></label>
                  <textarea class="form-control form-control-sm" name="address" rows="4">{{ old('address', auth()->user()->meta('address')) }}</textarea>
                  <div class="invalid-feedback d-block">{{ showError($errors, 'address') }}</div>
               </div>
               <div class="form-group">
                  <label>Note <span class="required">*</span></label>
                  <textarea class="form-control form-control-sm" name="note">{{ old('note') }}</textarea>
                  <div class="invalid-feedback d-block">{{ showError($errors, 'note') }}</div>
               </div>
               <div class="form-group">
                  <label>Your Invoice Number (Optional)</label>
                  <input type="text" class="form-control form-control-sm" name="staff_invoice_number" value="{{ old('staff_invoice_number') }}"> 
                  <div class="invalid-feedback d-block">{{ showError($errors, 'staff_invoice_number') }}</div>
               </div>

               <div class="form-group">
                  <label>Total</label>
                  <div>{{ format_money($data['total']) }}</div>
               </div>

               
               <button type="submit" class="btn btn-success btn-lg btn-block"><i class="far fa-paper-plane"></i> Request for payment</button>
            </form>
         
      </div>
   </div>
      </div>
      @else
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <img src="{{ asset('images/sad.svg') }}" class="img-fluid">
         <h5 class="text-center">Sorry, there is no unbilled work by you</h5>
      </div>
      <div class="col-md-4"></div>
      @endif
   </div>
</div>
@endsection