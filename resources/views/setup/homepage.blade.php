@extends('setup.index')
@section('title', 'Homepage Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_settings_homepage') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Homepage Contents'])
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active">Website Frontend</li>
         <li class="breadcrumb-item" aria-current="page">Homepage</li>
      </ol>
   </nav>
   <div class="container">
      <div class="row">
         <div class="offset-md-2 col-md-8">
            <br>
            @foreach($data['records'] as $row)
            @if($data['fields'][$row['option_key']] == 'input')
            <div class="form-group">
               <label>{{ ucfirst(str_replace('_',' ', $row['option_key'])) }}</label>
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, $row['option_key']) }}" name="{{ $row['option_key'] }}" value="{{ old($row['option_key'], $row['option_value'])  }}">
               <div class="invalid-feedback">{{ showError($errors, $row['option_key']) }}</div>
            </div>
            @else
            <div class="form-group">
               <label>{{ ucfirst(str_replace('_',' ', $row['option_key'])) }}</label>
               <textarea class="form-control form-control-sm {{ showErrorClass($errors, $row['option_key']) }}" name="{{ $row['option_key'] }}" rows="4">{{ old($row['option_key'], $row['option_value'])  }}</textarea>
               <div class="invalid-feedback">{{ showError($errors, $row['option_key']) }}</div>
            </div>
            @endif
            @endforeach
         </div>
      </div>
   </div>
</form>
@endsection