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
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{ (isset($postCategory->id)) ? route( 'post_category.edit', $postCategory->id) : route('post_category.store') }}"
          method="post" autocomplete="off">
        {{ csrf_field()  }}
        <div class="form-group">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <label>@lang('Name') <span class="required">*</span></label>
                        @foreach(Config::get('app.available_locales') as $lang)
                            <input id="name_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}"
                                   name="name[{{$lang}}]"
                                   value="{{ $postCategory->getTranslation('name',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                        @endforeach
                        <div class="invalid-feedback d-block">{{ showError($errors, 'name[]') }}</div>
                    </div>
                    <div class="col-md-2">
                        <label style="visibility: hidden">@lang('lang')  <span></span></label>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0">
                                    {{Config::get('app.locale')}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuLink">
                                    @foreach(Config::get('app.available_locales') as $lang)
                                        <li aria-haspopup="true">
                                            <a href="#" data-value="{{$lang}}" onclick="test(this)" class="dropdown-item translate-form"
                                               style="text-align-last: center;">
                                                {{$lang}}<br>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <label>@lang('Meta Desc') <span class="required">*</span></label>
                        @foreach(Config::get('app.available_locales') as $lang)
                            <textarea id="meta_desc_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc[]') }}"
                                      name="meta_desc[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ $postCategory->getTranslation('meta_desc',$lang) }}</textarea>
                            {{--                                {{ old_set('meta_desc['.$lang.']', NULL, $postCategory ?? '') }}--}}
                             @endforeach
                        <div class="invalid-feedback d-block">{{ showError($errors, 'name[]') }}</div>
                    </div>
                    <div class="col-md-2">
                        <label style="visibility: hidden">@lang('lang')  <span></span></label>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0">
                                    {{Config::get('app.locale')}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuLink">
                                    @foreach(Config::get('app.available_locales') as $lang)
                                        <li aria-haspopup="true">
                                            <a href="#" data-value="{{$lang}}" onclick="test(this)" class="dropdown-item locals"
                                               style="text-align-last: center;">
                                                {{$lang}}<br>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="form-group">--}}
{{--            <label>Meta Desc <span class="required">*</span></label>--}}
{{--            <textarea type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc') }}"--}}
{{--                      name="meta_desc">{{ old_set('meta_desc', NULL, $postCategory ?? '') }}</textarea>--}}
{{--            <div class="invalid-feedback d-block">{{ showError($errors, 'desc') }}</div>--}}
{{--        </div>--}}
        <div class="form-group">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <label>@lang('keywords')<span class="required">*</span></label>
                        @foreach(Config::get('app.available_locales') as $lang)
                            <input id="keyword_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword') }}"
                                   name="keyword[{{$lang}}]"
                                   value="{{ $postCategory->getTranslation('keyword',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                        @endforeach
                        <div class="invalid-feedback d-block">{{ showError($errors, 'keyword[]') }}</div>
                    </div>
                    <div class="col-md-2">
                        <label style="visibility: hidden">@lang('lang')  <span></span></label>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0">
                                    {{Config::get('app.locale')}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuLink">
                                    @foreach(Config::get('app.available_locales') as $lang)
                                        <li aria-haspopup="true">
                                            <a href="#" data-value="{{$lang}}" onclick="test(this)" class="dropdown-item translate-form"
                                               style="text-align-last: center;">
                                                {{$lang}}<br>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
        <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
    </form>

@endsection
<script>
    function test($this){
        var local = $this.getAttribute("data-value");
        // var locals = $('.locals')
        // for (j=0 ; j < locals.length ; j++){
        //
        // }
        // console.log(locals[0])
        if (local == "ar"){
            document.getElementById('name_'+local).setAttribute('style','display:block')
            document.getElementById('name_en').setAttribute('style','display:none')
            document.getElementById('name_fr').setAttribute('style','display:none')
            document.getElementById('keyword_'+local).setAttribute('style','display:block')
            document.getElementById('keyword_en').setAttribute('style','display:none')
            document.getElementById('keyword_fr').setAttribute('style','display:none')
            document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
            document.getElementById('meta_desc_en').setAttribute('style','display:none')
            document.getElementById('meta_desc_fr').setAttribute('style','display:none')
            var x = $('.navbarDarkDropdownMenuLink')
            for (i=0 ; i < x.length ;i++){
                x[i].innerHTML = local
            }
            console.log($('.navbarDarkDropdownMenuLink')[0].innerHTML )
        }else if (local =="en"){
            document.getElementById('name_'+local).setAttribute('style','display:block')
            document.getElementById('name_ar').setAttribute('style','display:none')
            document.getElementById('name_fr').setAttribute('style','display:none')
            document.getElementById('keyword_'+local).setAttribute('style','display:block')
            document.getElementById('keyword_ar').setAttribute('style','display:none')
            document.getElementById('keyword_fr').setAttribute('style','display:none')
            document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
            document.getElementById('meta_desc_ar').setAttribute('style','display:none')
            document.getElementById('meta_desc_fr').setAttribute('style','display:none')
            var x = $('.navbarDarkDropdownMenuLink')
            for (i=0 ; i < x.length ;i++){
                x[i].innerHTML = local
            }
        }else if (local == "fr"){
            document.getElementById('name_'+local).setAttribute('style','display:block')
            document.getElementById('name_en').setAttribute('style','display:none')
            document.getElementById('name_ar').setAttribute('style','display:none')
            document.getElementById('keyword_'+local).setAttribute('style','display:block')
            document.getElementById('keyword_en').setAttribute('style','display:none')
            document.getElementById('keyword_ar').setAttribute('style','display:none')
            document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
            document.getElementById('meta_desc_en').setAttribute('style','display:none')
            document.getElementById('meta_desc_ar').setAttribute('style','display:none')
            var x = $('.navbarDarkDropdownMenuLink')
            for (i=0 ; i < x.length ;i++){
                x[i].innerHTML = local
            }
        }
    }
</script>
