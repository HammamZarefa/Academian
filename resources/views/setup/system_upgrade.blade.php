@extends('setup.index')
@section('title', 'System update')
@section('setting_page')
@include('setup.partials.action_toolbar', ['title' => 'System update', 'hide_save_button' => true])
@if($data['prowriters_version'] == get_software_version())
    You are running Prowriters version: {{ get_software_version() }}
@else
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('update_system') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}   
   <div class="text-info"><b>*** Please make sure to create a backup copy of your database before running the upgrade.<b></div>
    <br>
   <button type="submit" name="submit" class="btn btn-sm btn-success" id="submitForm">
    <i class="fas fa-cogs"></i> Upgrade to v.{{ get_software_version() }}
    </button>  
</form>
@endif
@endsection