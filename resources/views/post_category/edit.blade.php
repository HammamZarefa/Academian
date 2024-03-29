@extends('layouts.app')
@section('title', 'Post Category')
@section('content')


    @include('setup.partials.action_toolbar', [
     'title' => (isset($postCategory->id)) ? 'Edit post categories' : 'Create new post categories',
     'hide_save_button' => TRUE,
     'back_link' => [
                      'title' => 'back to post categories',
                      'url' => route("post_categories")
                   ]
    ])
    <div class="container">
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{ (isset($postCategory->id)) ? route( 'post_category.edit', $postCategory->id) : route('post_category.store') }}"
          method="post" autocomplete="off">
        {{ csrf_field()  }}
        @include('language_selector')
        @foreach(Config::get('app.available_locales') as $lang)
        <div class="form-{{$lang}} col-sm-10 {{ showErrorClass($errors, 'form.*') }}">
        <div class="form-group side-form">
           
                        <label>@lang('Name') <span class="required">*</span></label>
                      
                            <input id="name_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}"
                                   name="name[{{$lang}}]"
                                   value="{{ $postCategory->getTranslation('name',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                        <div class="invalid-feedback d-block">{{ showError($errors, 'name[]') }}</div>
        </div>
        <div class="form-group side-form">
                        <label>@lang('Meta Desc') <span class="required">*</span></label>
                            <textarea id="meta_desc_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc[]') }}"
                                      name="meta_desc[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ $postCategory->getTranslation('meta_desc',$lang) }}</textarea>
                            {{--                                {{ old_set('meta_desc['.$lang.']', NULL, $postCategory ?? '') }}--}}
                        <div class="invalid-feedback d-block">{{ showError($errors, 'name[]') }}</div>
        </div>
{{--        <div class="form-group">--}}
{{--            <label>Meta Desc <span class="required">*</span></label>--}}
{{--            <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc') }}"--}}
{{--                      name="meta_desc">{{ old_set('meta_desc', NULL, $postCategory ?? '') }}</textarea>--}}
{{--            <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>--}}
{{--        </div>--}}
        <div class="form-group side-form">
                        <label>@lang('keywords')<span class="required">*</span></label>
                            <input id="keyword_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}"
                                   name="keyword[{{$lang}}]"
                                   value="{{ $postCategory->getTranslation('keyword',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                        <div class="invalid-feedback d-block">{{ showError($errors, 'keyword[]') }}</div>
        </div>
        </div>
        @endforeach

{{--        <div class="form-group">--}}
{{--            <label>keywords<span class="required">*</span></label>--}}
{{--            <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}"--}}
{{--                   name="keyword" value="{{ old_set('keyword', NULL, $postCategory ?? '') }}">--}}
{{--            <div class="invalid-feedback">{{ showError($errors, 'image') }}</div>--}}
{{--        </div>--}}
        {{--<div class="form-group">--}}
        {{--<div class="custom-control custom-checkbox">--}}
        {{--<input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $service_categories) ? 'checked="checked"' : '' }}>--}}
        {{--<label class="custom-control-label" for="inactive">Inactive</label>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="col-sm-12 d-flex justify-content-start mt-4">
            <input type="submit" name="submit" class="btn btn-Create" value="Submit"/>
        </div>
    </form>
    </div>

@endsection
