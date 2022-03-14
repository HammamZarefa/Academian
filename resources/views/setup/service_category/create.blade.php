@extends('setup.index')
@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($serviceCategory->id)) ? 'Edit service categories' : 'Create new service categories',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to service categories',
                  'url' => route("service_category_list")
               ]
])
 <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($serviceCategory->id)) ? route( 'service_category_update', $serviceCategory->id) : route('service_category_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($serviceCategory->id))
   {{ method_field('PATCH') }}
   @endif
   <div class="form-group">
      <label>@lang('Name') <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $serviceCategory ?? '') }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('Desc') <span class="required">*</span></label>
      <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'desc') }}" name="desc">{{ old_set('desc', NULL, $serviceCategory ?? '') }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('Image')</label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'image') }}" name="image" value="{{ old_set('image', NULL, $serviceCategory ?? '') }}">
      <div class="invalid-feedback">{{ showError($errors, 'image') }}</div>
   </div>
     <div class="form-group">
         <label>@lang('Need Work Level')</label>
         <input type="checkbox" class="form-control form-control-sm {{ showErrorClass($errors, 'worklevel') }}" name="worklevel" value=1 checked>
     </div>
   {{--<div class="form-group">--}}
      {{--<div class="custom-control custom-checkbox">--}}
         {{--<input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $service_categories) ? 'checked="checked"' : '' }}>--}}
         {{--<label class="custom-control-label" for="inactive">Inactive</label>--}}
      {{--</div>--}}
   {{--</div>--}}
   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>
@endsection
