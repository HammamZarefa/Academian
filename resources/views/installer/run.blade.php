@extends('installer.template')
@section('title', "Installation in progress")
@section('content')

<div class="card mx-auto mt-5" style="width: 28rem; margin-bottom: 10%;">
   <div class="card-body">
   	  <h1 class="card-title text-center"><i class="fas fa-cog" style="color: green;"></i></h1>
      <h4 class="text-center">Installation in progress ...</h4>
      <div class="text-center">Please wait while we install your application</div>
      <br>
      <div class="loader mx-auto"></div>
   </div>
</div>      
@endsection

@section('onPageJs')


<script>
    $(function () {   		

   	
		$.post( "{{ route('run_installation_step_4') }}" , { _token : "{{ csrf_token() }}" } )
	        .done(function( response ) {
	            
	            window.location = "{{ route('installation_result') }} ";
	        }).fail(function() {
    			
    			window.location = "{{ route('installation_failed') }}";
  			})  

    });
</script>

@endsection