@extends('installer.template')
@section('title', ($data['status'] == 1) ? 'Installation Complete' : 'Installation Failed')
@section('content')

<div class="row">
	<div class="offset-md-2 col-md-8">
		<div class="card mt-5" style="margin-bottom: 10%;">
			<div class="card-body">
			   <h4 class="card-title"><i class="fas {{ $data['icon'] }}"></i> {{ $data['title'] }}</h4>
			   <hr>
				 <p><b><?php echo $data['msg']; ?></b></p> 
				 
				 @if($data['status'] == 1)
					 <p class="text-muted" style="font-size: 14px;">
						 After login, please go through the <a target="_blank" href="https://microelephant.io/prowriters/after-installation">After-Installation</a> setup 
						 instructions on our documentation page and make sure to follow them all. Configure
						 everything one by one, for example, Email, Currency, Services setup, etc	 
					 </p>
					 <p class="text-muted" style="font-size: 14px;">
						Note that, If you start using the application before configuring 
						your settings, you might run into error pages. So please make sure 
						to set up everything before you start using the application.
					 </p>
					 <p style="font-size: 14px;">For support please send us an email at <b>support@microelephant.io</b> with your purchase code</p>
					 <table class="table table-sm">
						 <tr>
							 <td>Email</td>
							 <td class="text-right">admin@demo.com</td>
						 </tr>
						 <tr>
							 <td>Password</td>
							 <td class="text-right">123456</td>
						 </tr>
					 </table>        
					 <a href="{{ route('dashboard') }}"class="btn btn-primary">Go to Login page</a>
				 @endif
			</div>
		 </div>

	</div>
</div>
@endsection      