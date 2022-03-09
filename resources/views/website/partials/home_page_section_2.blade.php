<div class="mb-100">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="single_about_info text-center pb-5">
	            <h3>{!! homepage('section_2_title') !!}</h3>
	            <div>{!! homepage('section_2_sub_title') !!}</div>
            </div>
		</div>
		@if(isset($data['services']) && count($data['services']) > 0)
			@foreach($data['services'] as $services)
			<div class="col-md-3">
				<ul class="font-14">
					@foreach($services as $service)
					<li>{{ $service['name'] }}</li>
					@endforeach
				</ul>
			</div>
			@endforeach
		@endif
	</div>	
</div>
</div>