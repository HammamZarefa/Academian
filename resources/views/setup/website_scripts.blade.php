@extends('setup.index')
@section('title', 'Custom website header & footer scripts')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_custom_script') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Custom Website Header & Footer Scripts'])
   
   <p class="text-muted">
      <span class="required">*</span> Please note that if you want to add a css/js code you have to include the css/js tag as well
   </p>
	
    <div class="form-group">
       <label>Header Script</label>
       <small class="text-muted">Codes inserted below will be injected between the header tag, during run time</small>
       <textarea class="form-control form-control-sm {{ showErrorClass($errors, 'website_header_script') }}" name="website_header_script" rows="4">{{ old_set('website_header_script', NULL, $data['records'])  }}</textarea>
       <div class="invalid-feedback d-block">{{ showError($errors, 'website_header_script') }}</div>
    </div>
    
     <div class="form-group">
       <label>Footer Script</label>
       <small class="text-muted">Codes inserted below will be injected in the footer section, during run time</small>
       <textarea class="form-control form-control-sm {{ showErrorClass($errors, 'website_footer_script') }}" name="website_footer_script" rows="4">{{ old_set('website_footer_script', NULL, $data['records'])  }}</textarea>
       <div class="invalid-feedback d-block">{{ showError($errors, 'website_footer_script') }}</div>
    </div>
    
</form>
@endsection