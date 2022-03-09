@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($additional_service->id)) ? 'Edit additional service' : 'Create new additional service', 
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to additional services', 
                  'url' => route("additional_services_list")
               ]
])
 <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($additional_service->id)) ? route( 'additional_services_update', $additional_service->id) : route('additional_services_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($additional_service->id))
   {{ method_field('PATCH') }}
   @endif
   <div class="form-group">
      <label>Name <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $additional_service) }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
   </div>
   <div class="form-group">
      <label>Description <span class="required">*</span></label>
      <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'description') }}" name="description">{{ old_set('description', NULL, $additional_service) }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'description') }}</div>
   </div>
   <div class="form-group">
      <label>Price / Rate<span class="required">*</span></label>               
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'rate') }}" name="rate" value="{{ old_set('rate', NULL, $additional_service) }}">
      <div class="invalid-feedback">{{ showError($errors, 'rate') }}</div>
   </div>
   <div class="form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $additional_service) ? 'checked="checked"' : '' }}>
         <label class="custom-control-label" for="inactive">Inactive</label>
      </div>
   </div>
   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>
@endsection