@extends('setup.index')
@extends('setup.index')
@section('title', 'Post')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($post->id)) ? 'Edit post' : 'Create new post',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to post ',
                  'url' => route("posts")
               ]
])
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($post->id)) ? route( 'post.edit', $post->id) : route('post.store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   <div class="form-group">
      <div class="picture-container">
         <div class="picture">
            <img src="" class="picture-src" id="wizardPicturePreview" height="200px" width="400px" title=""/>
            <input type="file" id="wizard-picture" name="cover" class="form-control {{$errors->first('cover') ? "is-invalid" : "" }} ">
            <div class="invalid-feedback">
               {{ $errors->first('logo') }}</div>

         </div>
         <h6>@lang('Upload Cover')</h6>
      </div>
   </div>
   <div class="form-group">
      <label>@lang('Name') <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $post ?? '') }}">
      <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('Meta Desc') <span class="required">*</span></label>
      <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc') }}" name="meta_desc">{{ old_set('meta_desc', NULL, $post ?? '') }}</textarea>
      <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>
   </div>
   <div class="form-group">
      <label>@lang('keywords')<span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}" name="keyword" value="{{ old_set('keyword', NULL, $post ?? '') }}">
      <div class="invalid-feedback">{{ showError($errors, 'image') }}</div>
   </div>
   {{--<div class="form-group">--}}
      {{--<div class="custom-control custom-checkbox">--}}
         {{--<input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $service_categories) ? 'checked="checked"' : '' }}>--}}
         {{--<label class="custom-control-label" for="inactive">Inactive</label>--}}
      {{--</div>--}}
   {{--</div>--}}
   <input type="submit" name="submit" class="btn btn-success" value="@lang('Submit')"/>
</form>
@endsection
