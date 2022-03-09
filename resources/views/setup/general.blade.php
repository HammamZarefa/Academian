@extends('setup.index')
@section('title', 'General Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ 
   route('patch_general_information') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'General information'])
   <div class="form-group">
      <label class="form-control-label">Company Name <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'company_name') }}" name="company_name" value="{{ old_set('company_name', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'company_name') }}</div>
   </div>
   <div class="form-row">
      <div class="form-group col-md-6">
         <label>Phone <span class="required">*</span></label>
         <input type="text" class="form-control {{ showErrorClass($errors, 'company_phone') }}" name="company_phone" value="{{ old_set('company_phone', NULL, $rec) }}">
         <div class="invalid-feedback d-block">{{ showError($errors, 'company_phone') }}</div>
      </div>
      <div class="form-group col-md-6">
         <label>Email <span class="required">*</span></label>
         <input type="text" class="form-control {{ showErrorClass($errors, 'company_email') }}" name="company_email" value="{{ old_set('company_email', NULL, $rec) }}">
         <div class="invalid-feedback d-block">{{ showError($errors, 'company_email') }}</div>
      </div>
   </div>
   <div class="form-group">
      <label>Address <span class="required">*</span></label>
      <textarea class="form-control {{ showErrorClass($errors, 'company_address') }}" rows="3" name="company_address">{{ old_set('company_address', NULL, $rec) }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'company_address') }}</div>
   </div>
   <div class="form-group">
      <label>Number of times a customer can request for revision of their work 
      <small class="text-muted"> (Enter -1 for unlimited times) </small><span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'number_of_revision_allowed') }}" name="number_of_revision_allowed" value="{{ old_set('number_of_revision_allowed', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'number_of_revision_allowed') }}</div>
   </div>
   <div class="form-row">
      <div class="form-group col-md-6">
         <label>Email for receiving notifications <span class="required">*</span>
         <span data-toggle="tooltip" title="All system notification emails will be sent to this address"><i class="fas fa-question-circle"></i></span>
         </label>
         <input type="text" class="form-control {{ showErrorClass($errors, 'company_notification_email') }}" name="company_notification_email" value="{{ old_set('company_notification_email', NULL, $rec) }}" >
         <div class="invalid-feedback d-block">{{ showError($errors, 'company_notification_email') }}</div>
      </div>
   </div>
   <div class="form-group">
      <?php
      $hide_website = (old('hide_website', (optional($rec)->hide_website))) ? 'checked' : '';
       ?>
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="hide_website"  name="hide_website" value="1"
         {{ $hide_website }}
         >
         <label class="custom-control-label" for="hide_website">Hide Website</label>
      </div>
   </div>
</form>
@endsection
@section('innerPageJS')
<script>
   $(function() {       

      $('.selectpicker').select2({
          theme: 'bootstrap4',
      });

       $('.selectPickerWithoutSearch').select2({
          theme: 'bootstrap4',
         minimumResultsForSearch: -1
      }); 
      
      
   });


</script>
@endsection