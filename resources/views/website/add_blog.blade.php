@extends('layouts.app')
@section('title', 'Post')
@section('content')
{{--@include('setup.partials.action_toolbar', [--}}
{{--     'title' =>  'Create new post',--}}
{{--     'hide_save_button' => false,--}}

{{--    ])--}}

<div class="container">
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
      action="{{ (isset($post->id)) ? route( 'post.edit', $post->id) : route('post.storeBlog') }}" method="post"
      autocomplete="off" style="margin-top: 25px;">
        <div class="row">
               @include('language_selector')
                @foreach(Config::get('app.available_locales') as $lang)
            <div class="form-{{$lang}} col-sm-8 {{ showErrorClass($errors, 'form.*') }}">
                    <div class="side-form mb-4">
                        <label>@lang('Title') <span class="required">*</span></label>
                        <input id="title_{{$lang}}" type="text"
                               class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ old_set('title['.$lang.']', NULL, $postCategory ?? '') }}">
                        <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                    </div>

                    <div class="textdesc side-form mb-4">
                        <label>@lang('Desc') <span class="required">*</span></label>
                        <textarea  type="text"
                                  class="summernote form-control form-control-sm {{ showErrorClass($errors, 'body.*') }}"
                                  name="body[{{$lang}}]">{{ old_set('body['.$lang.']', NULL, $postCategory ?? '') }}
                        </textarea>
                    </div>
                    <div class="side-form mb-4">
                        <label>@lang('keywords')<span class="required">*</span></label>
                        <input id="keyword_{{$lang}}" type="text"
                               class="form-control form-control-sm {{ showErrorClass($errors, 'keyword.*') }}"
                               name="keyword[{{$lang}}]"
                               value="{{ old_set('keyword['.$lang.']', NULL, $postCategory ?? '') }}">
                        <div class="invalid-feedback d-block">{{ showError($errors, 'keyword.*') }}</div>
                    </div>
                    <div class="side-form">
                        <label>@lang('Meta Desc') <span class="required">*</span></label>
                        <textarea id="meta_desc_{{$lang}}" type="text"
                                  class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc.*') }}"
                                  name="meta_desc[{{$lang}}]">{{ old_set('meta_desc['.$lang.']', NULL, $postCategory ?? '') }}</textarea>
                        <div class="invalid-feedback d-block">{{ showError($errors, 'meta_desc.*') }}</div>
                    </div>
                        <div class="pdf" style="display: none">
                            <label>@lang('Desc') <span class="required">*</span></label>
                            <div class="mb-3">
                                <input class="form-control" type="file" id="formFile" name="body">
                            </div>
                        </div>
                        <div class="invalid-feedback d-block">{{ showError($errors, 'body.*') }}</div>
            </div>
            @endforeach

            <div class="col-sm-4">
                {{ csrf_field()  }}
                    {{--   check if the post is pdf     --}}
            <div class="form-check form-switch side-form mb-4">
                    <input class="xcheck" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Is PDF
                    </label>
                <div class="form-group">
                    <div class="picture-container">
                        <div class="picture" style="text-align: -webkit-center;">
                            <img src="{{asset('/images/write_blog.jpg')}}" class="picture-src mt-2 mb-2" id="wizardPicturePreview" height="150px" width="150px"
                                 title=""/>
                            <input type="file" id="wizard-picture" name="cover"
                                   class="form-control mt-2 mb-2  {{$errors->first('cover') ? "is-invalid" : "" }} ">
                            <div class="invalid-feedback">
                                {{ $errors->first('cover') }}</div>

                        </div>
                        <!-- <h6>@lang('Upload Cover')</h6> -->
                    </div>
                </div>
                </div>
                    <div class="form-group side-form">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <select name='category' class="form-control {{$errors->first('category') ? "is-invalid" : "" }} "
                                id="category">
                            <option disabled selected>Choose One!</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('category') }}
                        </div>
                    </div>
                <div class="form-group side-form">
                    <label for="tags" class=" col-form-label">Tags</label>
                <div>
                <select class="selectpicker" multiple name="tags[]" >
                                @foreach ($tags as $tags)
                                <option value="{{ $tags->id }}">{{ $tags->name }}</option>
                            @endforeach
                    </select>
                </div>
                </div> 
                <!-- <div class="side-form">
                    <div class="form-check form-switch d-flex align-items-center p-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                        id="feature" name="scrapeSources"  value="1" style="margin-inline-start: 0;">
                        <label class="form-check-label" for="feature" style="margin-inline-start: 40px;">is Featured ?</label>
                    </div>
                </div> -->
      
     <div class="col-sm-12 d-flex justify-content-end mt-4">
        <input type="submit" name="submit" class="btn btn-Create" value="@lang('Submit')"/>
     </div>
    </form>
        </div>
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
    <script type="text/javascript">
        $(function(){
            $(".xcheck").click(
            function (event) {
                var x = $(this).is(':checked');
                if(x==true){
                    $(this).parents(".form-check").find(".pdf").show();
                    $(this).parents(".form-check").find(".textdesc").hide();
                    $(this).parents(".form-check").find(".picture-container").hide();
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
    <script>
        $("#wizard-picture").change(function () {
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Choose Some Tags"
            });
        });

    </script>
@endpush
