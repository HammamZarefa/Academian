@extends('layouts.app')
@section('title', 'Payments')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
         <h4>@lang('Pending Payment Approval')</h4>
         <br>
      </div>
      <div class="col-md-6 text-right">
      <a class="btn btn-sm btn-success approve" href="{{ route('pending_payment_approve', $payment->id) }}"><i class="far fa-thumbs-up"></i>@lang('Approve') </a>
      <a class="btn btn-sm btn-danger disapprove" href="{{ route('pending_payment_disapprove', $payment->id) }}"><i class="far fa-thumbs-down"></i>@lang('Disapprove')</a>
      </div>
      <div class="col-md-8">
         <div class="card order-box">
            <h5>{{ $order->title }}</h5>
            <div>
               <span class="badge badge-brilliant-rose">
               {{ $order->service->price_type->name }}
               </span>
            </div>
            <hr>
            <div>
                @lang('Client') : <a href="{{ route('user_profile', $order->customer_id) }}">{{ $order->customer->full_name }}</a>
             </div>

            <p class="order-instruction">
               <?php echo $order->instruction; ?>
            </p>
            <div class="row order-overview">
               <div class="col-md-6"><span class="font-weight-bold">@lang('Service Type')</span>
                  <br>
                  {{ $order->service->name }}
                  @if($order->service->price_type_id == PriceType::PerPage)
                  <div class="font-12 text-danger"><i>* ({{ $order->spacing_type}} @lang('spacing'))</i></div>
                  @endif
               </div>
               <div class="col-md-6">
                  <span class="font-weight-bold">@lang('Deadline')</span>
                  <br>
                  {{ $order->urgency->value }} {{ $order->urgency->type }}
               </div>
            </div>
            <div class="row order-overview">
               <div class="col-md-6">
                  <span class="font-weight-bold">@lang('Additional Services')</span>
                  <br>
                  <ol class="pl-4">
                     @foreach($order->added_services as $service)
                     <li>{{ $service->name }} - {{ format_money($service->rate) }}</li>
                     @endforeach
                  </ol>
               </div>
               <div class="col-md-6">
                  <div class="font-weight-bold">@lang('Quantity')</div>
                  {{ $order->quantity }} {{ $order->unit_name }}
               </div>
            </div>
            <div class="row order-overview">
               <div class="col-md-6">
                  <div class="font-weight-bold">@lang('Attachments')</div>
                  <ol class="pl-4">
                     @isset($order->attachments)
                     @foreach($order->attachments as $attachment)
                     <li><a target="_blank" href="{{ route('download_attachment', 'file=' .  $attachment->name) }}">{{ $attachment->display_name }}</a></li>
                     @endforeach
                     @endisset
                  </ol>
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-4">
        <div class="card order-box">
            <h5>@lang('Payment Information')</h5>
            <table class="table table-sm">
               <tr style="border:0px;">
                   <td>@lang('Method')</td>
                   <td>: {{ $payment->method }}</td>
                </tr>
                <tr>
                    <td>@lang('Reference')</td>
                    <td>: {{ $payment->reference }}</td>
                 </tr>
                 <tr>
                    <td>@lang('Attachment')</td>
                    <td>
                        @if($payment->attachment)
                            {!! anchor('Download', route('download_attachment', ['file' => $payment->attachment])) !!}
                        @endif
                    </td>
                 </tr>
            </table>
        </div>

        <div class="card order-box">
            <h5>@lang('Financial Summary')</h5>
            <table class="table table-sm">
                <tr style="border:0px;">
                   <td colspan="3"><b>@lang('Item')</b></td>
                </tr>
                <tr>
                   <td colspan="2">
                      <div>{{ $order->service->name }}</div>
                      <div class="font-12">
                         {{ $order->work_level->name }} <i>(@lang('Work level'))</i>
                      </div>
                      <div class="font-12">
                        {{ $order->urgency->value }} {{ $order->urgency->type }} <i>(@lang('Urgency'))</i>
                     </div>

                   </td>
                   <td class="text-right" style="vertical-align: middle;">{{ format_money($order->amount) }}</td>
                </tr>
                @if($order->added_services)
                <tr style="border:0px;">
                   <td colspan="3"><b>@lang('Additional Services')</b></td>
                </tr>
                @foreach($order->added_services as $added_service)
                <tr>
                   <td>{{ $added_service->name }}</td>
                   <td></td>
                   <td class="text-right">{{ format_money($added_service->rate)}}</td>
                </tr>
                @endforeach
                @endif
                <tr>
                   <th>@lang('Total')</th>
                   <td></td>
                   <th class="text-right">{{ format_money($order->total) }}</th>
                </tr>
                <tr>
                   <td>(-) @lang('Staff Payment')</td>
                   <td></td>
                   <td class="text-right">{{ ($order->staff_payment_amount) ? format_money($order->staff_payment_amount) : 'Not set' }}</td>
                </tr>
                <tr>
                   <th>@lang('Profit')</th>
                   <td></td>
                   <th class="text-right">{{ ($order->staff_payment_amount) ? format_money($order->total - $order->staff_payment_amount) : 'Staff payment is not set' }}</th>
                </tr>
             </table>
        </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).on("click", '.approve', function (e) {

            e.preventDefault();
            var href = $(this).attr('href');
            swal(href, 'Yes, Approve');

        });

        $(document).on("click", '.disapprove', function (e) {

            e.preventDefault();
            var href = $(this).attr('href');
            swal(href, 'Yes, Disapprove');

        });


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });


        function swal(url, $confirmButtonText) {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: $confirmButtonText,
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                }
            })

        }

    </script>
@endpush
