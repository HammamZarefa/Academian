@extends('setup.index')
@section('title', 'Offline Payment Methods')
@section('setting_page')

@include('setup.partials.action_toolbar', [
'title' => (isset($method->id)) ? 'Edit offline payment method' : 'Create new offline payment method',
'hide_save_button' => TRUE,
'back_link' => ['title' => 'back to offline payment methods', 'url' => route("offline_payment_methods")],
])
<form role="form" class="form-horizontal" enctype="multipart/form-data"
    action="{{ (isset($method->id)) ? route( 'offline_payment_method_update', $method->id) : route('offline_payment_method_store') }}"
    method="post" autocomplete="off">
    {{ csrf_field() }}
    @if(isset($method->id))
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
                               value="{{ $method->getTranslation('name',$lang) }}" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}"  >
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
    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label>@lang('Description') <span class="required">*</span></label>
                    @foreach(Config::get('app.available_locales') as $lang)
                        <textarea id="description_{{$lang}}" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'description[]') }}"
                                  name="description[{{$lang}}]" style="display: {{$lang == Config::get('app.locale') ? "block" : "none"}}">{{ $method->getTranslation('description',$lang) }}</textarea>
                        {{--                                {{ old_set('description['.$lang.']', NULL, $method ?? '') }}--}}
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



    <div class="form-group">
        <label>@lang('Message to display after submitting the payment request') <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'success_message') }}"
            name="success_message" value="{{ old_set('success_message', NULL, $method) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'success_message') }}</div>
    </div>

    <div class="form-group">
        <label>@lang('Instruction to customer') <small class="text-muted">(@lang('e.g bank name, account number, swift code etc'). )</small></label>
        <textarea
            class="form-control form-control-sm {{ showErrorClass($errors, 'instruction') }}"
            name="instruction">{{ old_set('instruction', NULL, $method) }}</textarea>
        <div class="invalid-feedback d-block">{{ showError($errors, 'instruction') }}</div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="requires_transaction_number"
                name="requires_transaction_number" value="1"
                {{ old_set('requires_transaction_number', NULL, $method->settings) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="requires_transaction_number">@lang('Requires Evidence') / @lang('Transaction number')</label>
        </div>
    </div>

    <div class="form-group reference_field_label"
        style="{{ hideElementIfApplicable('requires_transaction_number', $method->settings) }}">
        <label>@lang('Field name to display for entering transaction number') <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'reference_field_label') }}"
            name="reference_field_label"
            value="{{ old_set('reference_field_label', NULL, $method->settings) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'reference_field_label') }}
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="requires_uploading_attachment"
                name="requires_uploading_attachment" value="1"
                {{ old_set('requires_uploading_attachment', NULL, $method->settings) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="requires_uploading_attachment">@lang('Requires Uploading attachment')</label>
        </div>
    </div>

    <div class="form-group attachment_field_label"
        style="{{ hideElementIfApplicable('requires_uploading_attachment', $method->settings) }}">
        <label>@lang('Field name to display for attachment uploading') <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'attachment_field_label') }}"
            name="attachment_field_label"
            value="{{ old_set('attachment_field_label', NULL, $method->settings) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'attachment_field_label') }}
        </div>
    </div>



    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1"
                {{ old_set('inactive', NULL, $method) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="inactive">@lang('Inactive')</label>
        </div>
    </div>
    <input type="submit" name="submit" class="btn btn-success" value="Submit" />
</form>
@endsection

@section('innerPageJS')
<script>
    $(function () {

        $('#requires_transaction_number').on('click', function () {

            if (this.checked) {
                $('.reference_field_label').show();
            } else {
                $('.reference_field_label').hide();
            }

        });

        $('#requires_uploading_attachment').on('click', function () {

            if (this.checked) {
                $('.attachment_field_label').show();
            } else {
                $('.attachment_field_label').hide();
            }

        });


    });

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
