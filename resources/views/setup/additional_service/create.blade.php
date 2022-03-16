@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($additional_service->id)) ? 'Edit additional service' : 'Create new additional service',
 'hide_save_button' => TRUE,
 'back_link' => [
                  'title' => 'back to additional services',
                  'url' => route("additional_services_list")
               ]
])
 <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($additional_service->id)) ? route( 'additional_services_update', $additional_service->id) : route('additional_services_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($additional_service->id))
   {{ method_field('PATCH') }}
   @endif
     <div class="form-group">
         <div class="container">
             <div class="row">
                 <div class="col-md-10">
                     <label>@lang('Name') <span class="required">*</span></label>
                     @foreach(Config::get('app.available_locales') as $lang)
                         <input id="name_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name.*') }}"
                                name="name[{{$lang}}]"
                                value="{{ old_set('name['.$lang.']', NULL, $postCategory ?? '') }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
                     @endforeach
                     <div class="invalid-feedback d-block">{{ showError($errors, 'name.*') }}</div>
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
                     <label>@lang('Description') <span class="required">*</span></label>
                     @foreach(Config::get('app.available_locales') as $lang)
                         <textarea id="description_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'description.*') }}"
                                   name="description[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ old_set('description['.$lang.']', NULL, $postCategory ?? '') }}</textarea>
                     @endforeach
                     <div class="invalid-feedback d-block">{{ showError($errors, 'description.*') }}</div>
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
      <label>@lang('Price') / @lang('Rate')<span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'rate') }}" name="rate" value="{{ old_set('rate', NULL, $additional_service) }}">
      <div class="invalid-feedback">{{ showError($errors, 'rate') }}</div>
   </div>
   <div class="form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $additional_service) ? 'checked="checked"' : '' }}>
         <label class="custom-control-label" for="inactive">@lang('Inactive')</label>
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
                document.getElementById('description_'+local).setAttribute('style','display:block')
                document.getElementById('description_en').setAttribute('style','display:none')
                document.getElementById('description_fr').setAttribute('style','display:none')
                document.getElementById('description_de').setAttribute('style','display:none')
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
                document.getElementById('description_'+local).setAttribute('style','display:block')
                document.getElementById('description_ar').setAttribute('style','display:none')
                document.getElementById('description_fr').setAttribute('style','display:none')
                document.getElementById('description_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "fr"){
                document.getElementById('name_'+local).setAttribute('style','display:block')
                document.getElementById('name_en').setAttribute('style','display:none')
                document.getElementById('name_ar').setAttribute('style','display:none')
                document.getElementById('name_de').setAttribute('style','display:none')
                document.getElementById('description_'+local).setAttribute('style','display:block')
                document.getElementById('description_en').setAttribute('style','display:none')
                document.getElementById('description_ar').setAttribute('style','display:none')
                document.getElementById('description_de').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }else if (local == "de"){
                document.getElementById('name_'+local).setAttribute('style','display:block')
                document.getElementById('name_en').setAttribute('style','display:none')
                document.getElementById('name_ar').setAttribute('style','display:none')
                document.getElementById('name_fr').setAttribute('style','display:none')
                document.getElementById('description_'+local).setAttribute('style','display:block')
                document.getElementById('description_en').setAttribute('style','display:none')
                document.getElementById('description_ar').setAttribute('style','display:none')
                document.getElementById('description_fr').setAttribute('style','display:none')
                var x = $('.navbarDarkDropdownMenuLink')
                for (i=0 ; i < x.length ;i++){
                    x[i].innerHTML = local
                }
            }
        }
    </script>
@endsection
