@extends('setup.index')
@section('title', 'Employee Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ 
   route('patch_settings_staff') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Employee'])
   <div class="form-row">
      <div class="form-group col-md-6">
         <label>Allow staffs to browse work <span class="required">*</span></label>
         <?php
            echo form_dropdown('enable_browsing_work', $data['enable_browsing_work'], old_set('enable_browsing_work', NULL, $rec) , "class='form-control enable_browsing_work selectPickerWithoutSearch'");
            ?>
         <div class="invalid-feedback d-block">{{ showError($errors, 'enable_browsing_work') }}</div>
      </div>
      <div class="form-group col-md-6 staff-payment-inputs">
         <label>Staff payment type <span class="required">*</span></label>                     
         <?php
            echo form_dropdown('staff_payment_type', $data['staff_payment_types'], old_set('staff_payment_type', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");
            ?>
         <div class="invalid-feedback d-block">{{ showError($errors, 'staff_payment_type') }}</div>
      </div>
   </div>
   <div class="form-group staff-payment-inputs">
      <label>Staff payment amount <span class="required">*</span>
      <span data-toggle="tooltip" title="Will be automatically calculated when an order is placed, if Browse Work is enabled"><i class="fas fa-question-circle"></i></span>
      </label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'staff_payment_amount') }}" name="staff_payment_amount" value="{{ old_set('staff_payment_amount', NULL, $rec) }}" placeholder="Enter amount here">
      <div class="invalid-feedback d-block">{{ showError($errors, 'staff_payment_amount') }}</div>
   </div>
</form>
@endsection
@section('innerPageJS')
<script>
   $(function() {
      
      <?php if(old_set('enable_browsing_work', NULL, $rec) == 'yes') { ?>

         showStaffPaymentInputs()

      <?php } else {?>

         hideStaffPaymentInputs();

      <?php } ?>   

      $('.selectpicker').select2({
          theme: 'bootstrap4',
      });

       $('.selectPickerWithoutSearch').select2({
          theme: 'bootstrap4',
         minimumResultsForSearch: -1
      });
   
      
      $('.enable_browsing_work').change(function(e){

         if($(this).val() == 'yes')
         {
            showStaffPaymentInputs();
         }
         else
         {
             hideStaffPaymentInputs();
         }

      });
   });



   function hideStaffPaymentInputs()
   {
      $('.staff-payment-inputs').hide();
   }

   function showStaffPaymentInputs()
   {
      $('.staff-payment-inputs').show();
   }
   
   
</script>
@endsection