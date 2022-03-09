@extends('setup.index')
@section('title', 'Google Analytics Tracking Code')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_google_analytics') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Google Analytics Tracking Code'])
   <div class="form-group">
      <label>Tracking Code</label>
      <small class="text-muted"></small>
      <input class="form-control form-control-sm {{ showErrorClass($errors, 'google_analytics_tracking_code') }}" name="google_analytics_tracking_code" value="{{ old_set('google_analytics_tracking_code', NULL, $data['records'])  }}" placeholder="Example: UA-34294382-6" />
      <div class="invalid-feedback d-block">{{ showError($errors, 'google_analytics_tracking_code') }}</div>
   </div>
</form>
@endsection