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
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($video->id)) ? route( 'video.update', $video->id) : route('video.store') }}" method="post" autocomplete="off" >
    {{ csrf_field()  }}
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Title') <span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <input id="title_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'title.*') }}"
                               name="title[{{$lang}}]"
                               value="{{ $video->getTranslation('title',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
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
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Video URL')<span class="required">*</span></label>
                    <input type="text"
                           class="form-control form-control-sm {{ showErrorClass($errors, 'url') }}"
                           name="url" value="{{ old('url') != null ? old('url') : $video->url }}">
                    <div class="invalid-feedback">{{ showError($errors, 'url') }}</div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div>is Featured?  <input type="checkbox" id="feature" name="feature"  {{$video->feature ? "checked" : ""}} value="1"></div>
                </div>
            </div>

        </div>
    </div>

    <input type="submit" name="submit" class="btn btn-success" value="@lang('Submit')"/>
</form>
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
</script>
@endpush
