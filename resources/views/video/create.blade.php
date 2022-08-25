@extends('layouts.app')
@section('title', 'Video')
@section('content')

@include('setup.partials.action_toolbar', [
 'title' => (isset($post->id)) ? 'Edit Video' : 'Add new Video',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to videos ',
                  'url' => route("videos")
               ]
])
<div class="container">
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($post->id)) ? route( 'video.edit', $post->id) : route('video.store') }}" method="post" autocomplete="off" >
    {{ csrf_field()  }}
    @include('language_selector')

    <div class="container">
    <div class="form-group side-form">
                  <div class="d-flex">
                  <label class="mr-4">@lang('Type:')</label>
                    <div id="type">
                        @lang('Video')<input class="ml-1 mr-4" type="radio" name="type" checked="checked" value="1"  />
                        @lang('Image')<input class="ml-1 mr-4" type="radio" name="type" value="0" />
                    </div>
                  </div>
                    @foreach(Config::get('app.available_locales') as $lang)
                    <div class="form-{{$lang}} side-form col-sm-12 {{ showErrorClass($errors, 'form.*') }}">
                    <label>@lang('Title') <span class="required">*</span></label>
                    
                        <input id="title_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ old_set('title['.$lang.']', NULL, $postCategory ?? '') }}">
                    
                    <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                </div>
                @endforeach
    <div class="form-group side-form" id="videotype">
                    <label>@lang('Video URL')<span class="required">*</span></label>
                    <input type="text"
                           class="form-control form-control-sm {{ showErrorClass($errors, 'url') }}"
                           name="url" value="{{ old('url') }}">
                    <div class="invalid-feedback">{{ showError($errors, 'url') }}</div>
    </div>
        <div class="form-group side-form" id="imagetype" >
            <div class="picture-container">
                <div class="picture">
                    <img src="" class="picture-src mt-2 mb-2" id="wizardPicturePreview" height="150px" width="150px" title=""/>
                    <input type="file" id="wizard-picture" name="url" class="form-control mt-2 mb-2 {{$errors->first('cover') ? "is-invalid" : "" }} ">
                    <div class="invalid-feedback">
                        {{ $errors->first('cover') }}</div>

                </div>
                <h6 class="mt-2 mb-2 p-1 d-none">@lang('Upload Cover')</h6>
            </div>
        </div>
    </div>
    <div class="form-group side-form">
                <div class="col-md-10">
                    is Featured?  <input type="checkbox" id="feature" name="feature" value="1" >
                </div>

    </div>
    </div>
    <div class="col-sm-12 d-flex justify-content-start mt-4">
        <input type="submit" name="submit" class="btn btn-Create" value="@lang('Submit')"/>
    </div>
   
</form>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#imagetype").hide();

            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                if(inputValue==0)
                {
                $("#videotype").hide();
                $("#imagetype").show();
                }else
                {
                    $("#videotype").show();
                    $("#imagetype").hide();
                }
            });
        });
    </script>
@endpush

