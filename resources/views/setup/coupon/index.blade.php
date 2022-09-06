@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

<style type="text/css">
   .toolbar {
    float: left;
}

</style>
@include('setup.partials.action_toolbar', [
 'title' => 'Coupons',
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create Coupon', 'url' => route("coupon_create")]

 ])
<table id="table" class="table table-striped">
  <thead>
     <tr>
        <th scope="col">@lang('Code')</th>
        <th scope="col" class="text-right">@lang('Amount')</th>
         <th scope="col" class="text-right">@lang('Type')</th>
         <th scope="col" class="text-right">@lang('Start At')</th>
         <th scope="col" class="text-right">@lang('Expired At')</th>
         <th scope="col">Status</th>
        <th scope="col" class="text-right">@lang('Action')</th>
     </tr>
  </thead>
    @foreach($coupons as $coupon)
        <tr>
            <td scope="col" class="text-right">{{$coupon->code}}</td>
            <td scope="col" class="text-right">{{$coupon->amount}}</td>
            <td scope="col" class="text-right">{{$coupon->type}}</td>
            <td scope="col" class="text-right">{{$coupon->start_at}}</td>
            <td scope="col" class="text-right">{{$coupon->expired_at}}</td>
            <td scope="col" class="text-right">{{$coupon->status}}</td>
            <td>
                <a href="{{route('coupon_status', [$coupon->id])}}" class="btn btn-Create btn-sm">
                    @if($coupon->status=='enable')
                        <i class="far fa-eye"></i>
                        @else
                            <i class="far fa-eye-slash"></i>
                @endif
                </a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Move post to trash ?')" action="{{route('coupons_destroy', $coupon->id)}}">
                    @csrf
                    <input type="hidden" value="DELETE" name="_method">
                    <input type="submit" value="Trash" class="btn btn-danger btn-sm">
                </form>
            </td>
        </tr>
        @endforeach
</table>
@endsection


