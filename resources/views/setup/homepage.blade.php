@extends('setup.index')
@section('title', 'Homepage Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_settings_homepage') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Homepage Contents'])
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active">@lang('Website Frontend')</li>
         <li class="breadcrumb-item" aria-current="page">@lang('Homepage')</li>
      </ol>
      @include('language_selector')
   </nav>
   <div class="container">
      <div class="row">
         <div class="offset-md-2 col-md-8">
            <br>
            @foreach(Config::get('app.available_locales') as $lang)
            @foreach($data['records'] as $row)
            @if($data['fields'][$row['option_key']] == 'input')
            <div class="form-group form-{{$lang}}">
               <label>{{ ucfirst(str_replace('_',' ', $row['option_key'])) }}</label>
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, $row['option_key']) }}" name="{{ $row['option_key'] }}[{{$lang}}]" value="{{ old($row['option_key'], json_decode($row['option_value'])->$lang)  }}">
               <div class="invalid-feedback">{{ showError($errors, $row['option_key']) }}</div>
            </div>
            @else
            <div class="form-group form-{{$lang}}">
               <label>{{ ucfirst(str_replace('_',' ', $row['option_key'])) }}</label>
               <textarea class="form-control form-control-sm {{ showErrorClass($errors, $row['option_key']) }}" name="{{ $row['option_key'] }}[{{$lang}}]" rows="4">{{ old($row['option_key'], json_decode($row['option_value'])->$lang)  }}</textarea>
               <div class="invalid-feedback">{{ showError($errors, $row['option_key']) }}</div>
            </div>
            @endif
            @endforeach
               @endforeach
         </div>
      </div>
   </div>
</form>
@endsection
