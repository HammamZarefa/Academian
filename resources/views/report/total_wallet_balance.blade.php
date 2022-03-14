@extends('layouts.app')
@section('title', 'Income Statement')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>@lang('Total Wallet Balance') (@lang('Currently'))</h4>
         <small class="text-muted">@lang('The following amount is the summation of wallet balances of all the users').</small>
         <small class="text-muted">@lang('Balance in wallets are advance payments and they do not reflect in your income statement')</small>
         <hr>
         <h5>@lang('Total') : {{ format_money($data['balance']) }}<h5>

      </div>
   </div>

</div>
@endsection
