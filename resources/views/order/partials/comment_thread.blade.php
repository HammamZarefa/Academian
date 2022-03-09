@if(count($comments = $order->comments()->orderBy('id', 'DESC')->paginate()) > 0)
<hr>
<h4>Conversations</h4>
<p class="text-muted"><small>Sorted based on most recent comment</small></p>
@foreach($comments as $comment)
<div id="thread_{{ $comment->id }}" class="{{ ($comment->user_id == auth()->user()->id) ? 'thread-member' : 'thread-customer' }} comment-box">
   <div class="row">
      <div class="col-md-3">
         <p class="h6">
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('user_profile', $comment->user_id) }}">{{ $comment->user->full_name }}</a>
            @else
            {{ $comment->user->full_name }}
            @endif
         </p>
         <div class="text-muted">
            @if($order->customer_id == $comment->user_id)
            Client    
            @elseif($order->staff_id == $comment->user_id)
            Team Member
            @else
            Admin	
            @endif
         </div>
      </div>
      <div class="col-md-9 comment-body-parent">
         <?php echo nl2br($comment->body); ?>                       
      </div>
   </div>
   <br><br>
   <div class="comment-box-footer">
      Posted : {{ convertToLocalTime($comment->created_at, 'd-M-Y h:i:s a') }}
   </div>
</div>
@endforeach
{{ $comments->links() }}
@endif