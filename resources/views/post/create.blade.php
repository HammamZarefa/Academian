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
    <div class="container">
    <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{route('post.store') }}" method="post" autocomplete="off" >
        <div class="row">
               @include('language_selector')
                @foreach(Config::get('app.available_locales') as $lang)
            <div class="form-{{$lang}} col-sm-8 {{ showErrorClass($errors, 'form.*') }}">
                    <div class="side-form mb-4">
                        <label>@lang('Title') <span class="required">*</span></label>
                        <input id="title_{{$lang}}" type="text"
                        class="title_{{$lang}} form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                        name="title[{{$lang}}]"
                        value="{{ old_set('title['.$lang.']', NULL, $postCategory ?? '') }}">
                        <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                    </div>

                    <div class="textdesc side-form mb-4">
                            <label>@lang('Desc') <span class="required">*</span></label>
                                <textarea id="body_{{$lang}}" type="text"
                                          class="body_{{$lang}} summernote form-control form-control-sm {{ showErrorClass($errors, 'body.*') }}"
                                          name="body[{{$lang}}]"
                                         >{{ old_set('body['.$lang.']', NULL, $postCategory ?? '') }}</textarea>
                        </div>
                        <div class="side-form mb-4">
                        <label>@lang('keywords')<span class="required">*</span></label>
                            <input id="keyword_{{$lang}}" type="text" class="keyword_{{$lang}} form-control form-control-sm {{ showErrorClass($errors, 'keyword.*') }}"
                                   name="keyword[{{$lang}}]"
                                   value="{{ old_set('keyword['.$lang.']', NULL, $postCategory ?? '') }}">
                        <div class="invalid-feedback d-block">{{ showError($errors, 'keyword.*') }}</div>
                    </div>
                    <div class="side-form">
                        <label>@lang('Meta Desc') <span class="required">*</span></label>
                            <textarea id="meta_desc_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc.*') }}"
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
                    <input class="form-check-input xcheck" type="checkbox" role="switch"
                    id="flexCheckDefault" name="scrapeSources"  value="" style="margin-inline-start: 0;">
                    <label class="form-check-label" for="flexCheckDefault" style="margin-inline-start: 40px;"> PDF Post</label>
                    <input type="file" name="body" class="pdfs form-control mt-2 mb-2" style="display:none">
                <div class="form-group ">
                    <div class="picture-container">
                        <div class="picture">
                            <img src="" class="picture-src mt-2 mb-2" id="wizardPicturePreview" height="150px" width="150px" title=""/>
                            <input type="file" id="wizard-picture" name="cover" class="form-control mt-2 mb-2 {{$errors->first('cover') ? "is-invalid" : "" }} ">
                            <div class="invalid-feedback">
                                {{ $errors->first('cover') }}</div>

                        </div>
                        <h6 class="mt-2 mb-2 p-1 d-none">@lang('Upload Cover')</h6>
                    </div>
                </div>

                    </div>

                    <div class="form-group side-form">
            <label for="category" class=" col-form-label">Category</label>
            <div class="">
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
            <div class="side-form">

                <div class="form-check form-switch d-flex align-items-center p-0">
                    <input class="form-check-input" type="checkbox" role="switch"
                    id="feature" name="scrapeSources"  value="1" style="margin-inline-start: 0;">
                    <label class="form-check-label" for="feature" style="margin-inline-start: 40px;">is Featured ?</label>
                </div>
        </div>

     <div class="col-sm-12 d-flex justify-content-end mt-4">
     <input type="submit" name="submit" class="btn btn-Create" value="@lang('Submit')"/>
     </div>
    </form>
        </div>
@endsection
@push('scripts')
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
        $(document).ready(function() {
            console.log('ready');
        $('.summernote').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 500,
            // callbacks: {
            //     onImageUpload: function(image) {
            //         uploadImage(image[0]);
            //
            //     }
            // }
        })});

        // function uploadImage(image) {
        //     var data = new FormData();
        //     data.append("image", image);
        //     console.log('called successufly');
        //     $.ajax({
        //         url: "/my_flask_endpoint",
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         data: data,
        //         type: "POST",
        //         success: function(filename) {
        //             var image = $('<img>').attr('src', '/route/to/images/' + filename).addClass("img-fluid");
        //             $('#summernote').summernote("insertNode", image[0]);
        //         },
        //         error: function(data) {
        //             console.log(data);
        //         }
        //     });
        // }

    $(function(){
        $(".xcheck").click(
            function (event) {
                var x = $(this).is(':checked');
                if(x==true){
                    $(this).parents(".form-check").find(".pdf").show();
                    $(".textdesc").hide();
                    $(this).parents(".form-check").find(".picture-container").hide();
                    $(this).parents(".form-check").find(".pdfs").show();


                    // $(this).parents(".form-check").find(".form-group").hide();
                }else {
                    $(".textdesc").show();
                    $(this).parents(".form-check").find(".pdf").hide();
                    $(this).parents(".form-check").find(".pdfs").hide();
                    $(this).parents(".form-check").find(".picture-container").show();
                }
            }
        )});
</script>

@endpush
