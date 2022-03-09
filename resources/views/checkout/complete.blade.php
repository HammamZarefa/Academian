@extends('layouts.app')
@section('title', 'Successfully completed!')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h3>Successfully completed!</h3>        
         <hr>
         {{ $data['message']  }}
      </div>
   </div>  
</div>
@endsection
