@extends('installer.template')
@section('title', "Database Information")
@section('content')

<?php

function get_base_url()
{
    return URL::to('/') . "/";
}

?>


<div class="card mx-auto mt-5" style="width: 28rem; margin-bottom: 10%; font-size: 13px;">
   <div class="card-body">
      <h4 class="card-title">Database Information</h4>
      <hr>
      @if (Session::has('error_msg'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            {!! session('error_msg') !!}</div>
       @endif
      <form action="{{ route('run_installation_step_2') }}" method="POST">
        {{ csrf_field()  }}
         <div class="form-group">
            <label>App Base URL</label>
            <span class="form-text" style="font-size: 12px;">Base URL must not have space and it should end with a trailing slash</span>
            <input  type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'site_base_url') }}" name="site_base_url" 
            value="{{ old_set('site_base_url', get_base_url() , $rec) }}" >
            <div class="invalid-feedback">{{ showError($errors, 'site_base_url') }}</div>
         </div>
         <div class="form-group">
            <label>Database Host</label>
            <input  type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'db_host') }}" name="db_host" required value="{{ old_set('db_host', NULL, $rec) }}" placeholder="localhost">
            <div class="invalid-feedback">{{ showError($errors, 'db_host') }}</div>
         </div>
         <div class="form-group">
            <label>Database Name</label>
            <input  type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'db_name') }}" name="db_name" required value="{{ old_set('db_name', NULL, $rec) }}">
            <div class="invalid-feedback">{{ showError($errors, 'db_name') }}</div>
         </div>
         <div class="form-group">
            <label>Database User Name</label>
            <input type="text" name="db_user_name" class="form-control form-control-sm {{ showErrorClass($errors, 'db_user_name') }}" required value="{{ old_set('db_user_name', NULL, $rec) }}" placeholder="root">
            <div class="invalid-feedback">{{ showError($errors, 'db_user_name') }}</div>
         </div>
         <div class="form-group">
            <label>Database Password</label>
            <input type="text" name="db_user_password" class="form-control form-control-sm {{ showErrorClass($errors, 'db_user_password') }}" value="{{ old_set('db_user_password', NULL, $rec) }}">
            <div class="invalid-feedback">{{ showError($errors, 'db_user_password') }}</div>
         </div>
         <a class="btn btn-secondary  float-md-left" href="{{ route('installer_page') }}">Back</a>
     
         <input type="submit" name="submit" class="btn btn-primary float-md-right" value="Next" >
      </form>
   </div>
</div>

@endsection