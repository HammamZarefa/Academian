@extends('setup.index')
@section('title', 'Clear Cache')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => 'Clear settings cache', 
 'hide_save_button' => TRUE,
 
])

<form role="form" class="form-horizontal" action="{{ route('post_clear_cache') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
  
 <input type="submit" name="submit" class="btn btn-link" value="Clear cache"/>
</form>
@endsection
