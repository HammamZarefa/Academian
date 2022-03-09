@extends('installer.template')
@section('title', "Database Connected")
@section('content')

<div class="card mx-auto mt-5" style="width: 28rem; margin-bottom: 10%;">
   <div class="card-body">
      <h4 class="card-title"><i class="fas fa-check-circle"></i> Database Connected!</h4>
      <hr>
      	<br>
		<form action="{{ route('run_installation_step_4_page') }}" method="POST">
	        {{ csrf_field()  }}
	     
	       	<input type="submit" name="submit" class="btn btn-primary float-md-right" value="Install Now" >
	   	
	     </form>  
   </div>
</div>      
@endsection