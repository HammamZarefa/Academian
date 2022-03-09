@extends('setup.index')
@section('title', 'Currency Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ 
   route('patch_settings_currency') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Currency'])
   <div class="form-group">
      <label>Currency Symbol <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'settings.currency_symbol')}}" name="currency_symbol" value="{{ old_set('currency_symbol', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'currency_symbol') }}</div>
   </div>
   <div class="form-group">
      <label>Currency Code <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'settings.currency_code')}}" name="currency_code" value="{{ old_set('currency_code', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'currency_code') }}</div>
   </div>   
   <div class="form-group">
      <label>Digit Grouping <span class="required">*</span></label>
      <?php
         echo form_dropdown('digit_grouping_method', $data['dropdowns']['list_of_digit_grouping_methods'], old_set('digit_grouping_method', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");
         ?>
         <div class="invalid-feedback d-block">{{ showError($errors, 'digit_grouping_method') }}</div>
   </div>
   <div class="form-group">
      <label>Decimal Symbol <span class="required">*</span></label>
      <?php
         echo form_dropdown('decimal_symbol', $data['dropdowns']['decimal_symbol'], old_set('decimal_symbol', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");
         ?>
   </div>
   <div class="form-group">
      <label>Thousand Seperator <span class="required">*</span></label>                 
      <?php
         echo form_dropdown('thousand_separator', $data['dropdowns']['thousand_separator'], old_set('thousand_separator', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");
         ?>
   </div>
</form>
@endsection
@section('innerPageJS')
<script>
   $(function() {    
  
       $('.selectPickerWithoutSearch').select2({
          theme: 'bootstrap4',
         minimumResultsForSearch: -1
      });    
  
   });
   
</script>
@endsection