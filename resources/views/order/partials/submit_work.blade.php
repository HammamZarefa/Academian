@if($order->order_status_id == ORDER_STATUS_IN_PROGRESS)
 <submit-work 
:submit_work_url="'{{ route('submit_work', $order->id) }}'"
:upload_attachment_url="'{{ route('order_upload_attachment') }}'"></submit-work>

@elseif($order->order_status_id == in_array($order->order_status_id, [ORDER_STATUS_NEW, ORDER_STATUS_REQUESTED_FOR_REVISION]))

	@if($order->order_status_id == ORDER_STATUS_REQUESTED_FOR_REVISION)
		<?php $feedback = $order->latest_submitted_work(); ?>
		<div><small class="form-text text-muted">Posted at : {{ $feedback->updated_at }} </small></div>
		<label>Message from customer:</label>			
		<p>{{ $order->latest_submitted_work()->customer_message }}</p>
	@endif

	<form action="{{ route('start_working', $order->id) }}" method="POST" autocomplete="off">
		{{ csrf_field()  }}
		<input type="hidden" name="order_id" value="{{ $order->id }}">
		<button class="btn btn-success btn-lg btn-block" type="submit" name="submit"><i class="fas fa-rocket"></i> Start Working</button>
		
	</form>
@endif
