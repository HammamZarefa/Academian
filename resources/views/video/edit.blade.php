@extends('layouts.app')
@section('title', 'Video')
@section('content')


@include('setup.partials.action_toolbar', [
 'title' => (isset($video->id)) ? 'Edit video' : 'Create new video',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to videos ',
                  'url' => route("videos")
               ]
])
<div class="container">
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($video->id)) ? route( 'video.update', $video->id) : route('video.store') }}" method="post" autocomplete="off" >
    {{ csrf_field()  }}
    <div class="form-group side-form">
                <div class="d-flex">
                    <label class="mr-4">@lang('Type')</label>
                    <div id="type">
                        @lang('Video')<input class="ml-1 mr-4" type="radio" name="type" {{ ($video->type!=0)? "checked" : "" }} value="1"  />
                        @lang('Image')<input class="ml-1 mr-4" type="radio" name="type" {{ ($video->type==0)? "checked" : "" }} value="0" />
                    </div>
                    </div>
                    @foreach(Config::get('app.available_locales') as $lang)
                    <div class="form-{{$lang}} side-form col-sm-12 {{ showErrorClass($errors, 'form.*') }}">
                    <label>@lang('Title') <span class="required">*</span></label>
                    
                        <input id="title_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ $video->getTranslation('title',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                   
                    <div class="invalid-feedback d-block">{{ showError($errors, 'title.*') }}</div>
                </div>
                @endforeach
    <div class="form-group side-form" id="videotype">
                    <label>@lang('Video URL')<span class="required">*</span></label>
                    <input type="text"
                           class="form-control form-control-sm {{ showErrorClass($errors, 'url') }}"
                           name="url" value="{{ old('url') != null ? old('url') : $video->url }}">
                    <div class="invalid-feedback">{{ showError($errors, 'url') }}</div>
    </div>
    <div class="form-group side-form" id="imagetype" >
        <div class="picture-container">
            <div class="picture">
                <img src="" class="picture-src mt-2 mb-2" id="wizardPicturePreview" height="150px" width="150px" title=""/>
                <input type="file" id="wizard-picture" name="url" class="form-control mt-2 mb-2 {{$errors->first('cover') ? "is-invalid" : "" }} " value="{{ old('url') != null ? old('url') : $video->url }}">
                <div class="invalid-feedback">
                    {{ $errors->first('cover') }}</div>

            </div>
            <h6 class="mt-2 mb-2 p-1 d-none">@lang('Upload Cover')</h6>
        </div>
    </div>
    </div>

    <div class="form-group side-form">
                <div class="col-md-10">
                    <div>is Featured?  <input type="checkbox" id="feature" name="feature"  {{$video->feature ? "checked" : ""}} value="1"></div>
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
            document.getElementById('body_'+local).setAttribute('style','display:block')
            document.getElementById('body_en').setAttribute('style','display:none')
            document.getElementById('body_fr').setAttribute('style','display:none')
            document.getElementById('body_de').setAttribute('style','display:none')
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
            document.getElementById('body_'+local).setAttribute('style','display:block')
            document.getElementById('body_ar').setAttribute('style','display:none')
            document.getElementById('body_fr').setAttribute('style','display:none')
            document.getElementById('body_de').setAttribute('style','display:none')
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
            document.getElementById('body_'+local).setAttribute('style','display:block')
            document.getElementById('body_en').setAttribute('style','display:none')
            document.getElementById('body_ar').setAttribute('style','display:none')
            document.getElementById('body_de').setAttribute('style','display:none')
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
            document.getElementById('body_'+local).setAttribute('style','display:block')
            document.getElementById('body_en').setAttribute('style','display:none')
            document.getElementById('body_ar').setAttribute('style','display:none')
            document.getElementById('body_fr').setAttribute('style','display:none')
            var x = $('.navbarDarkDropdownMenuLink')
            for (i=0 ; i < x.length ;i++){
                x[i].innerHTML = local
            }
        }
    }

    $(document).ready(function(){
        var type=document.getElementsByName('type');
        if(type[0].checked)
        {
            $("#videotype").show();
            $("#imagetype").hide();
        }else
        {
            $("#videotype").hide();
            $("#imagetype").show();
        }
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
