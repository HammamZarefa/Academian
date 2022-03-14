@if(auth()->user()->hasRole('admin') ||  (auth()->user()->id ==  $order->staff_id))
  @if(count($works = $order->submitted_works()->orderBy('id', 'DESC')->paginate()) > 0)
   <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">@lang('Sl#')</th>
        <th scope="col">@lang('Company')</th>
        <th scope="col">@lang('Customer')</th>
      </tr>
    </thead>
    <tbody>
       @foreach ($works as $key=>$work)
      <tr>
        <th style="width: 10%;">{{ $key + 1 }}</th>
        <td style="width: 40%;">
        	<label>@lang('Message')</label>
        	<div>{{ $work->message }}</div>
        	<div><small class="form-text text-muted">Submitted at : {{ convertToLocalTime($work->created_at) }}</small></div>
        	<div>@lang('Attachment') : <a href="{{ route('download_attachment', 'file=' .  $work->name) }}">@lang('Download')</a></div>
        </td>
        <td style="width: 40%;">
        	@if($work->customer_message)
        	<label>@lang('Message')</label>
        	<div>{{ $work->customer_message }}</div>
        	<div><small class="form-text text-muted">@lang('Posted at') : {{ convertToLocalTime($work->updated_at) }}</small></div>   	@endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $works->links() }}
  @else
      @lang('No work has been submitted yet')
  @endif
@endif
