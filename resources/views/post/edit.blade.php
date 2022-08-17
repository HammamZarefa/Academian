@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<div class="container">

    <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($post->id)) ? route( 'post.edit', $post->id) : route('post.store') }}" method="post" autocomplete="off" >
 
<div class="row">
@include('language_selector')
                @foreach(Config::get('app.available_locales') as $lang)
            <div class="form-{{$lang}} col-sm-8 {{ showErrorClass($errors, 'form.*') }}">
                    <div class="side-form mb-4">
                        <label>@lang('Title') <span class="required">*</span></label>
                        <input id="title_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ $post->getTranslation('title',$lang) }}"  >
                        <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                    </div>

                    <div class="textdesc side-form mb-4">
                    <label>@lang('Desc') <span class="required">*</span></label>
                        <textarea id="body_{{$lang}}" type="text" class="summernote form-control form-control-sm {{ showErrorClass($errors, 'body.*') }}"
                                  name="body[{{$lang}}]" >{{ $post->getTranslation('body',$lang) }}</textarea>
                    <div class="invalid-feedback d-block">{{ showError($errors, 'body.*') }}</div>
                    </div>

                    <div class="side-form mb-4">
                    <label>@lang('keywords')<span class="required">*</span></label>
                        <input id="keyword_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'keyword.*') }}"
                               name="keyword[{{$lang}}]"
                               value="{{ $post->getTranslation('keyword',$lang) }}"   >
                    <div class="invalid-feedback d-block">{{ showError($errors, 'keyword.*') }}</div>
                    </div>

                    <div class="side-form">
                    <label>@lang('Meta Desc') <span class="required">*</span></label>
                        <textarea id="meta_desc_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'meta_desc.*') }}"
                                  name="meta_desc[{{$lang}}]" >{{ $post->getTranslation('meta_desc',$lang) }}</textarea>
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
                <div class="form-group side-form">
                    <div class="picture-container">
                        <div class="picture">
                            <img src="{{asset(Storage::url($post->cover))}}" class="picture-src mt-2 mb-2" id="wizardPicturePreview" height="150px" width="150px" title=""/>
                            <input type="file" id="wizard-picture" name="cover" class="mt-2 mb-2 form-control {{$errors->first('cover') ? "is-invalid" : "" }} ">
                            <div class="invalid-feedback">
                                {{ $errors->first('cover') }}</div>

                        </div>
                        <h6 class="d-none">@lang('Upload Cover')</h6>
                    </div>
                </div>

                    <div class="form-group side-form">
                    <label for="category" class="col-sm-2 col-form-label">Category</label>
                    <div class="">
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
            <div class="form-group side-form">
                <label for="tags" class=" col-form-label">Tags</label>
               <div>
               <select class="selectpicker" multiple name="tags[]" >
                        @foreach ($post->tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
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
</div>

    <div class="form-group ml-5">
       
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
@endpush
