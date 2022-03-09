@if(count($data['statistics']) > 0)
	@foreach($data['statistics'] as $segment)
  <div class="row mb-4">
		@foreach($segment as $row)
         <div class="col-md-2 col-sm-6">         	
         	<div class="shadow bg-white rounded text-center p-1">
            <div class="mt-2">{{ $row['value'] }}</div>
            <span style="font-size: 12px;" class="text-{{ str_replace('badge-','',$row['badge']) }}">{{ $row['name'] }}</span>
        	</div>        	
         </div>         
         @endforeach
    </div>
    <br>
    @endforeach
@endif
