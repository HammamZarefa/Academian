@extends('setup.index')
@extends('setup.index')
@section('title', 'Post Category')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($postCategory->id)) ? 'Edit post categories' : 'Create new post categories',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to post categories',
                  'url' => route("post_categories")
               ]
])
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($postCategory->id)) ? route( 'post_category.edit', $postCategory->id) : route('post_category.store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   <div class="form-group">
      <label>Name <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $postCategory ?? '') }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
   </div>
   <div class="form-group">
      <label>Meta Desc <span class="required">*</span></label>
      <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc') }}" name="meta_desc">{{ old_set('meta_desc', NULL, $postCategory ?? '') }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>
   </div>
   <div class="form-group">
      <label>keywords<span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}" name="keyword" value="{{ old_set('keyword', NULL, $postCategory ?? '') }}">
      <div class="invalid-feedback">{{ showError($errors, 'image') }}</div>
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