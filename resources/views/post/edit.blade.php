@extends('layouts.app')
@section('title', 'Blog')
@section('content')

    <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($post->id)) ? route( 'post.edit', $post->id) : route('post.store') }}" method="post" autocomplete="off" >
    {{ csrf_field()  }}
    <div class="form-group">
        <div class="picture-container">
            <div class="picture">
                <img src="{{asset(Storage::url($post->cover))}}" class="picture-src" id="wizardPicturePreview" height="200px" width="400px" title=""/>
                <input type="file" id="wizard-picture" name="cover" class="form-control {{$errors->first('cover') ? "is-invalid" : "" }} ">
                <div class="invalid-feedback">
                    {{ $errors->first('cover') }}</div>

            </div>
            <h6>@lang('Upload Cover')</h6>
        </div>
    </div>
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Title') <span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <input id="title_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ $post->getTranslation('title',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                    @endforeach
                    <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                </div>
                <div class="col-md-2">
                    <label style="visibility: hidden">@lang('lang')  <span></span></label>
                    <ul class="navbar-nav" style="background-color: #343a40;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;color: #FFFFFF">
                                {{Config::get('app.locale')}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark"
                                aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 3rem;">
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
    <div class="form-group ml-5">
        <label for="category" class="col-sm-2 col-form-label">Category</label>
        <div class="col-sm-9">
            <select name='category' class="form-control {{$errors->first('category') ? "is-invalid" : "" }} " id="category">
                <option disabled selected>Choose One!</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{$post->category_id == $category->id ? "selected" : ""}}>{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('category') }}
            </div>
        </div>
    </div>
    <div class="form-group ml-5">
        <label for="tags" class="col-sm-2 col-form-label">Tags</label>
        <div class="col-sm-9">
            <select name='tags[]' class="form-control {{$errors->first('tags') ? "is-invalid" : "" }} select2" id="tags" multiple>
                @foreach ($post->tags as $tag)
                    <option selected value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
                @foreach ($tags as $tags)
                    <option value="{{ $tags->id }}">{{ $tags->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('tags') }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Desc') <span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <textarea id="body_{{$lang}}" type="text" class="summernote form-control form-control-sm {{ showErrorClass($errors, 'body.*') }}"
                                  name="body[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ $post->getTranslation('body',$lang) }}</textarea>
                    @endforeach
                    <div class="invalid-feedback d-block">{{ showError($errors, 'body.*') }}</div>
                </div>
                <div class="col-md-2">
                    <label style="visibility: hidden"> @lang('lang') <span></span></label>
                    <ul class="navbar-nav" style="background-color: #343a40;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;color: #FFFFFF">
                                {{Config::get('app.locale')}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark"
                                aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 3rem;">
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
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('keywords')<span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <input id="keyword_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword.*') }}"
                               name="keyword[{{$lang}}]"
                               value="{{ $post->getTranslation('keyword',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                    @endforeach
                    <div class="invalid-feedback d-block">{{ showError($errors, 'keyword.*') }}</div>
                </div>
                <div class="col-md-2">
                    <label style="visibility: hidden">@lang('lang')  <span></span></label>
                    <ul class="navbar-nav" style="background-color: #343a40;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;color: #FFFFFF">
                                {{Config::get('app.locale')}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark"
                                aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 3rem;">
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
                        <textarea id="meta_desc_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc.*') }}"
                                  name="meta_desc[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ $post->getTranslation('meta_desc',$lang) }}</textarea>
                    @endforeach
                    <div class="invalid-feedback d-block">{{ showError($errors, 'meta_desc.*') }}</div>
                </div>
                <div class="col-md-2">
                    <label style="visibility: hidden"> @lang('lang') <span></span></label>
                    <ul class="navbar-nav" style="background-color: #343a40;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#" id="navbarDarkDropdownMenuLink"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;color: #FFFFFF">
                                {{Config::get('app.locale')}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark"
                                aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 3rem;">
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
            <div>is Featured?  <input type="checkbox" id="feature" name="feature"  {{$post->feature ? "checked" : ""}} value="1"></div>
        </div>
    </div>
    <input type="submit" name="submit" class="btn btn-success" value="@lang('Submit')"/>
</form>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var body1 = document.getElementById('body_en')
            var editor1 = body1.nextElementSibling;
            editor1.setAttribute('style','display:block');
            var body2 = document.getElementById('body_ar')
            var editor2 = body2.nextElementSibling;
            editor2.setAttribute('style','display:none');
            var body3 = document.getElementById('body_de')
            var editor3 = body3.nextElementSibling;
            editor3.setAttribute('style','display:none');
            var body4 = document.getElementById('body_fr')
            var editor4 = body4.nextElementSibling;
            editor4.setAttribute('style','display:none');
        });
    </script>
<script>
    $("#wizard-picture").change(function(){
        readURL(this);

    });
    //Function to show image before upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
    <script>
        function test($this){
            var local = $this.getAttribute("data-value");
            // var locals = $('.locals')
            // for (j=0 ; j < locals.length ; j++){
            //
            // }
            // console.log(locals[0])
            if (local == "ar"){
                document.getElementById('title_'+local).setAttribute('style','display:block')
                document.getElementById('title_en').setAttribute('style','display:none')
                document.getElementById('title_fr').setAttribute('style','display:none')
                document.getElementById('title_de').setAttribute('style','display:none')
                document.getElementById('keyword_'+local).setAttribute('style','display:block')
                document.getElementById('keyword_en').setAttribute('style','display:none')
                document.getElementById('keyword_fr').setAttribute('style','display:none')
                document.getElementById('keyword_de').setAttribute('style','display:none')
                document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
                document.getElementById('meta_desc_en').setAttribute('style','display:none')
                document.getElementById('meta_desc_fr').setAttribute('style','display:none')
                document.getElementById('meta_desc_de').setAttribute('style','display:none')
                var body1 = document.getElementById('body_'+local)
                var editor1 = body1.nextElementSibling;
                editor1.setAttribute('style','display:block');
                var body2 = document.getElementById('body_en')
                var editor2 = body2.nextElementSibling;
                editor2.setAttribute('style','display:none');
                var body3 = document.getElementById('body_de')
                var editor3 = body3.nextElementSibling;
                editor3.setAttribute('style','display:none');
                var body4 = document.getElementById('body_fr')
                var editor4 = body4.nextElementSibling;
                editor4.setAttribute('style','display:none');
                // document.getElementById('body_'+local).setAttribute('style','display:block')
                // document.getElementById('body_en').setAttribute('style','display:none')
                // document.getElementById('body_fr').setAttribute('style','display:none')
                // document.getElementById('body_de').setAttribute('style','display:none')
                // document.getElementById('cke_body_'+local).setAttribute('style','display:block')
                // document.getElementById('cke_body_en').setAttribute('style','display:none')
                // document.getElementById('cke_body_fr').setAttribute('style','display:none')
                // document.getElementById('cke_body_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
                console.log($('.navbarDarkDropdownMenuLink')[0].innerHTML )
            }else if (local =="en"){
                document.getElementById('title_'+local).setAttribute('style','display:block')
                document.getElementById('title_ar').setAttribute('style','display:none')
                document.getElementById('title_fr').setAttribute('style','display:none')
                document.getElementById('title_de').setAttribute('style','display:none')
                document.getElementById('keyword_'+local).setAttribute('style','display:block')
                document.getElementById('keyword_ar').setAttribute('style','display:none')
                document.getElementById('keyword_fr').setAttribute('style','display:none')
                document.getElementById('keyword_de').setAttribute('style','display:none')
                document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
                document.getElementById('meta_desc_ar').setAttribute('style','display:none')
                document.getElementById('meta_desc_fr').setAttribute('style','display:none')
                document.getElementById('meta_desc_de').setAttribute('style','display:none')
                var body1 = document.getElementById('body_'+local)
                var editor1 = body1.nextElementSibling;
                editor1.setAttribute('style','display:block');
                var body2 = document.getElementById('body_de')
                var editor2 = body2.nextElementSibling;
                editor2.setAttribute('style','display:none');
                var body3 = document.getElementById('body_ar')
                var editor3 = body3.nextElementSibling;
                editor3.setAttribute('style','display:none');
                var body4 = document.getElementById('body_fr')
                var editor4 = body4.nextElementSibling;
                editor4.setAttribute('style','display:none');
                // document.getElementById('body_'+local).setAttribute('style','display:block')
                // document.getElementById('body_ar').setAttribute('style','display:none')
                // document.getElementById('body_fr').setAttribute('style','display:none')
                // document.getElementById('body_de').setAttribute('style','display:none')
                // document.getElementById('cke_body_'+local).setAttribute('style','display:block')
                // document.getElementById('cke_body_ar').setAttribute('style','display:none')
                // document.getElementById('cke_body_fr').setAttribute('style','display:none')
                // document.getElementById('cke_body_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "fr"){
                document.getElementById('title_'+local).setAttribute('style','display:block')
                document.getElementById('title_en').setAttribute('style','display:none')
                document.getElementById('title_ar').setAttribute('style','display:none')
                document.getElementById('title_de').setAttribute('style','display:none')
                document.getElementById('keyword_'+local).setAttribute('style','display:block')
                document.getElementById('keyword_en').setAttribute('style','display:none')
                document.getElementById('keyword_ar').setAttribute('style','display:none')
                document.getElementById('keyword_de').setAttribute('style','display:none')
                document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
                document.getElementById('meta_desc_en').setAttribute('style','display:none')
                document.getElementById('meta_desc_ar').setAttribute('style','display:none')
                document.getElementById('meta_desc_de').setAttribute('style','display:none')

                var body1 = document.getElementById('body_'+local)
                var editor1 = body1.nextElementSibling;
                editor1.setAttribute('style','display:block');
                var body2 = document.getElementById('body_en')
                var editor2 = body2.nextElementSibling;
                editor2.setAttribute('style','display:none');
                var body3 = document.getElementById('body_ar')
                var editor3 = body3.nextElementSibling;
                editor3.setAttribute('style','display:none');
                var body4 = document.getElementById('body_de')
                var editor4 = body4.nextElementSibling;
                editor4.setAttribute('style','display:none');
                // document.getElementById('body_'+local).setAttribute('style','display:block')
                // document.getElementById('body_en').setAttribute('style','display:none')
                // document.getElementById('body_ar').setAttribute('style','display:none')
                // document.getElementById('body_de').setAttribute('style','display:none')
                // document.getElementById('cke_body_'+local).setAttribute('style','display:block')
                // document.getElementById('cke_body_en').setAttribute('style','display:none')
                // document.getElementById('cke_body_ar').setAttribute('style','display:none')
                // document.getElementById('cke_body_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "de"){
                document.getElementById('title_'+local).setAttribute('style','display:block')
                document.getElementById('title_en').setAttribute('style','display:none')
                document.getElementById('title_ar').setAttribute('style','display:none')
                document.getElementById('title_fr').setAttribute('style','display:none')
                document.getElementById('keyword_'+local).setAttribute('style','display:block')
                document.getElementById('keyword_en').setAttribute('style','display:none')
                document.getElementById('keyword_ar').setAttribute('style','display:none')
                document.getElementById('keyword_fr').setAttribute('style','display:none')
                document.getElementById('meta_desc_'+local).setAttribute('style','display:block')
                document.getElementById('meta_desc_en').setAttribute('style','display:none')
                document.getElementById('meta_desc_ar').setAttribute('style','display:none')
                document.getElementById('meta_desc_fr').setAttribute('style','display:none')
                var body1 = document.getElementById('body_'+local)
                var editor1 = body1.nextElementSibling;
                editor1.setAttribute('style','display:block');
                var body2 = document.getElementById('body_en')
                var editor2 = body2.nextElementSibling;
                editor2.setAttribute('style','display:none');
                var body3 = document.getElementById('body_ar')
                var editor3 = body3.nextElementSibling;
                editor3.setAttribute('style','display:none');
                var body4 = document.getElementById('body_fr')
                var editor4 = body4.nextElementSibling;
                editor4.setAttribute('style','display:none');
                // document.getElementById('body_en').setAttribute('style','display:none')
                // document.getElementById('body_ar').setAttribute('style','display:none')
                // document.getElementById('body_fr').setAttribute('style','display:none')
                // document.getElementById('cke_body_'+local).setAttribute('style','display:block')
                // document.getElementById('cke_body_en').setAttribute('style','display:none')
                // document.getElementById('cke_body_ar').setAttribute('style','display:none')
                // document.getElementById('cke_body_fr').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }
        }
    </script>
@endpush
