@extends('setup.index')
@section('title', 'Edit Tag')
@section('setting_page')
@include('setup.partials.action_toolbar', [
 'title' => (isset($tag->id)) ? 'Edit tag' : 'Create new tag',
 'hide_save_button' => TRUE,
 'back_link' => ['title' => 'back to tags', 'url' => route("tags_list")],
])

<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($tag->id)) ? route( 'tags_update', $tag->id) : route('tags_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($tag->id))
   {{ method_field('PATCH') }}
   @endif
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Name') <span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <input id="name_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}"
                               name="name[{{$lang}}]"
                               value="{{ $tag->getTranslation('name',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                    @endforeach
                    <div class="invalid-feedback d-block">{{ showError($errors, 'name[]') }}</div>
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

   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>

@endsection
@section('innerPageJS')
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
                document.getElementById('name_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
                console.log($('.navbarDarkDropdownMenuLink')[0].innerHTML )
            }else if (local =="en"){
                document.getElementById('name_'+local).setAttribute('style','display:block')
                document.getElementById('name_ar').setAttribute('style','display:none')
                document.getElementById('name_fr').setAttribute('style','display:none')
                document.getElementById('name_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "fr"){
                document.getElementById('name_'+local).setAttribute('style','display:block')
                document.getElementById('name_en').setAttribute('style','display:none')
                document.getElementById('name_ar').setAttribute('style','display:none')
                document.getElementById('name_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "de"){
                document.getElementById('name_'+local).setAttribute('style','display:block')
                document.getElementById('name_en').setAttribute('style','display:none')
                document.getElementById('name_ar').setAttribute('style','display:none')
                document.getElementById('name_fr').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }
        }
    </script>
@endsection
