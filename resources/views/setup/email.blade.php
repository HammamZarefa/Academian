@extends('setup.index')
@section('title', 'Email Settings')
@section('setting_page')
<style type="text/css">
   <?php 
      if(old_set('company_email_send_using', NULL, $rec) == 'mailgun') { ?>
   #otherMailConfigInfo{
   display: none;
   }
   #mailgunInfo{
   display: block;
   }
   <?php } else { ?> 
   #mailgunInfo{
   display: none;
   }
   #otherMailConfigInfo{
   display: block;
   }
   <?php } ?>
</style>

<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_settings_email') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Email Configuration'])
   <div class="row">
      <div class="form-group col-md-6">
         <label>Send email using <span class="required">*</span></label>
         <?php
            echo form_dropdown('company_email_send_using', 
               $data['email_sending_options'], old_set('company_email_send_using', NULL, $rec) , "class='form-control selectPickerWithoutSearch email_sending_options' ");
            ?>
      </div>
      <div class="form-group col-md-6 configuration">
         <label>Queue Connection <span class="required">*</span></label>
         <?php
            echo form_dropdown('queue_connection', 
               $data['queue_connection_options'], old_set('queue_connection', NULL, $rec) , "class='form-control selectPickerWithoutSearch queue_connection' ");
            ?>
      </div>
   </div>
   <div class="configuration">
   <div class="form-group">
      <label>Email From Address <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_from_address') }}" name="company_email_from_address" value="{{ old_set('company_email_from_address', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_from_address') }}</div>
   </div>
   <div id="mailgunInfo">
      <div class="form-row">
         <div class="form-group col-md-6">
            <label>Mailgun Domain <span class="required">*</span></label>
            <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_mailgun_domain') }}" name="company_email_mailgun_domain" value="{{ old_set('company_email_mailgun_domain', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_mailgun_domain') }}</div>
         </div>
         <div class="form-group col-md-6">
            <label>Mailgun Key <span class="required">*</span></label>
            <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_mailgun_key') }}" name="company_email_mailgun_key" value="{{ old_set('company_email_mailgun_key', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_mailgun_key') }}</div>
         </div>
      </div>
   </div>
   <div id="otherMailConfigInfo">
      <div class="form-row">
         <div class="form-group col-md-6">
            <label>Smtp Host <span class="required">*</span></label>
            <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_smtp_host') }}" name="company_email_smtp_host" value="{{ old_set('company_email_smtp_host', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_smtp_host') }}</div>
         </div>
         <div class="form-group col-md-3">
            <label>SMTP Port <span class="required">*</span></label>
            <input type="text" class="form-control  {{ showErrorClass($errors, 'company_email_smtp_port') }}" name="company_email_smtp_port" value="{{ old_set('company_email_smtp_port', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_smtp_port') }}</div>
         </div>
         <div class="form-group col-md-3">
            <label>Email Encryption <span class="required">*</span></label>
            <?php
               echo form_dropdown('company_email_encryption', [ '' => 'None','ssl' => 'SSL', 'tls' => 'TLS'], old_set('company_email_encryption', NULL, $rec) , "class='form-control selectPickerWithoutSearch' ");
               ?>
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_encryption') }}</div>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-6">
            <label><i class="fa fa-question-circle" data-toggle="tooltip" data-title="Fill only if your email client use username for SMTP login." data-original-title="" title=""></i> SMTP Username</label>
            <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_smtp_username') }}" name="company_email_smtp_username" value="{{ old_set('company_email_smtp_username', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_smtp_username') }}</div>
         </div>
         <div class="form-group col-md-6">
            <label>Smtp Password <span class="required">*</span> </label>
            <input type="text" class="form-control {{ showErrorClass($errors, 'company_email_smtp_password') }}" name="company_email_smtp_password" value="{{ old_set('company_email_smtp_password', NULL, $rec) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_email_smtp_password') }}</div>
         </div>
      </div>
   </div>
   </div>
</form>

@endsection
@section('innerPageJS')
<script>
   $(function() {
   
   $('select').select2({
          theme: 'bootstrap4',
           minimumResultsForSearch: -1
      });

      $('.email_sending_options').change(function(){

            if($(this).val() == 'mailgun')
            {
               $('.configuration').show();
               $("#mailgunInfo").show();
               $("#otherMailConfigInfo").hide();
            }
            else if($(this).val() == 'log')
            {
               $('.configuration').hide();
            }
            else
            {
               $("#mailgunInfo").hide();
               $("#otherMailConfigInfo").show();
               $('.configuration').show();
            }
      });
   

      $('.email_sending_options').trigger("change");
   
   });
   
   
</script>
@endsection