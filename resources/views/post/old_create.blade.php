@extends('layouts.app')
@section('title', 'Blog')

@section('content')
    @include('setup.partials.action_toolbar', [
     'title' =>  'Create new post',
     'hide_save_button' => TRUE,
     'back_link' => [
                      'title' => 'back to post ',
                      'url' => route("posts")
                   ]
    ])
    <style>
        #cke_body_ar {
            display: none;
        }
        #cke_body_fr {
            display: none;
        }
        #cke_body_de {
            display: none;
        }
    </style>
    <div class="container">
    <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($post->id)) ? route( 'post.edit', $post->id) : route('post.store') }}" method="post" autocomplete="off" >
        {{ csrf_field()  }}
{{--   check if the post is pdf     --}}
        <div class="form-check">
            <input class="xcheck" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                PDF Post
            </label>
        <div class="form-group">
            <div class="picture-container">
                <div class="picture">
                    <img src="" class="picture-src" id="wizardPicturePreview" height="150px" width="150px" title=""/>
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
                                   value="{{ old_set('title['.$lang.']', NULL, $postCategory ?? '') }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
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
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <div class="textdesc">
                            <label>@lang('Desc') <span class="required">*</span></label>
                            @foreach(Config::get('app.available_locales') as $lang)
                                <textarea id="body_{{$lang}}" type="text"
                                          class="summernote form-control form-control-sm {{ showErrorClass($errors, 'body.*') }}"
                                          name="body[{{$lang}}]"
                                          style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ old_set('body['.$lang.']', NULL, $postCategory ?? '') }}</textarea>
                            @endforeach
                        </div>
                        <div class="pdf" style="display: none">
                            <label>@lang('Desc') <span class="required">*</span></label>
                            <div class="mb-3">
                                <input class="form-control" type="file" id="formFile" name="body">
                            </div>
                        </div>
                        <div class="invalid-feedback d-block">{{ showError($errors, 'body.*') }}</div>
                    </div>
                    <div class="col-md-1">
                        <label style="visibility: hidden"> @lang('lang') <span></span></label>
                        <ul class="navbar-nav" style="background-color: #343a40;width: 50%;">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle navbarDarkDropdownMenuLink" href="#"
                                   id="navbarDarkDropdownMenuLink"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                   style="padding: 0;color: #FFFFFF">
                                    {{Config::get('app.locale')}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 3rem;">
                                    @foreach(Config::get('app.available_locales') as $lang)
                                        <li aria-haspopup="true">
                                            <a href="#" data-value="{{$lang}}" onclick="test(this)"
                                               class="dropdown-item locals"
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
                                   value="{{ old_set('keyword['.$lang.']', NULL, $postCategory ?? '') }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
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
                                      name="meta_desc[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ old_set('meta_desc['.$lang.']', NULL, $postCategory ?? '') }}</textarea>
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
                <div>is Featured?  <input type="checkbox" id="feature" name="feature" value="1" ></div>
            </div>
        </div>
        <input type="submit" name="submit" class="btn btn-success" value="@lang('Submit')"/>
    </form>
        </div>
@endsection
@push('scripts')
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            $('.ckeditor').ckeditor();--}}
{{--        });--}}
{{--    </script>--}}
    <script>
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
        $(document).ready(function() {
            console.log('ready')
        $('#summernote').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 500,
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                }
            }
        }});

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            console.log('called successufly');
            $.ajax({
                url: "/my_flask_endpoint",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(filename) {
                    var image = $('<img>').attr('src', '/route/to/images/' + filename).addClass("img-fluid");
                    $('#summernote').summernote("insertNode", image[0]);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

    </script>
    <script type="text/javascript">
    $(function(){
        $(".xcheck").click(
            function (event) {
                var x = $(this).is(':checked');
                if(x==true){
                    $(this).parents(".form-check").find(".pdf").show();
                    $(this).parents(".form-check").find(".textdesc").hide();
                    $(this).parents(".form-check").find(".picture-container").hide();
                    // $(this).parents(".form-check").find(".form-group").hide();
                }else {
                    $(this).parents(".form-check").find(".textdesc").show();
                    $(this).parents(".form-check").find(".pdf").hide();

                }

            }
        )});
    if($("#flexCheckDefault").checked){
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
    }
    else{
    };
</script>

@endpush
