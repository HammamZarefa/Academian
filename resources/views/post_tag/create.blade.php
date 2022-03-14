@extends('setup.index')
@extends('setup.index')
@section('title', 'Post Tag')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($tag->id)) ? 'Edit post tag' : 'Create new post tag',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to post tags',
                  'url' => route("post_tags")
               ]
])
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($tag->id)) ? route( 'post_tag.edit', $tag->id) : route('post_tag.store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   <div class="form-group">
      <label>@lang('Name') <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $tag ?? '') }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('Meta Desc') <span class="required">*</span></label>
      <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc') }}" name="meta_desc">{{ old_set('meta_desc', NULL, $tag ?? '') }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('keywords')<span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}" name="keyword" value="{{ old_set('keyword', NULL, $tag ?? '') }}">
      <div class="invalid-feedback">{{ showError($errors, 'image') }}</div>
   </div>
   {{--<div class="form-group">--}}
      {{--<div class="custom-control custom-checkbox">--}}
         {{--<input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $service_tags) ? 'checked="checked"' : '' }}>--}}
         {{--<label class="custom-control-label" for="inactive">Inactive</label>--}}
      {{--</div>--}}
   {{--</div>--}}
   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>
@endsection
