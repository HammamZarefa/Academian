@if(auth()->user()->hasRole('admin') || (auth()->user()->id ==  $order->customer_id ) )
<div class="container">
   <div class="row">
      <div class="offset-md-1 col-md-10">
         <div class="card">
            <div class="card-body">
               <div class="h2 text-center">
                  Financial
               </div>
               <table class="table table-sm">
                  @if(auth()->user()->hasRole('admin'))
                     <tr style="border:0px;">
                        <td colspan="3"><b>Service Item</b></td>
                     </tr>
                     <tr>
                        <td>
                           <div>
                              <span style="font-size: 22px;">{{ $order->service->name }}</span>  -  
                              {{ format_money($order->base_price) }}
                              <span style="font-size: 12px;" class="text-muted">(Base Price)</span> 
                           </div>
                           <div style="font-size: 14px;">                           
                              {{ $order->work_level->name }} <i>(Work level)</i> - 
                              {{ format_money($order->work_level_price) }}
                              <span style="font-size: 12px;" class="text-muted">  
                              {{ $order->work_level_percentage }}% of Base Price
                              </span>
                           </div>
                           <div style="font-size: 14px;">      
                              Urgency - {{ format_money($order->urgency_price) }}
                              <span style="font-size: 12px;" class="text-muted">     
                              {{ $order->urgency_percentage }}% of Base Price
                              </span>
                           </div>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                           {{ format_money($order->unit_price) }} x {{ $order->quantity }} <span style="font-size: 12px;" class="text-muted">({{ $order->unit_name }})</span>
                        </td>
                        <td class="text-right" style="vertical-align: middle;">{{ format_money($order->amount) }}</td>
                     </tr>
                     @if($order->added_services()->exists())
                     <tr style="border:0px;">
                        <td colspan="3"><b>Additional Services</b></td>
                     </tr>
                     @foreach($order->added_services as $added_service)                   
                     <tr>
                        <td>{{ $added_service->name }}</td>
                        <td></td>
                        <td class="text-right">{{ format_money($added_service->rate)}}</td>
                     </tr>
                     @endforeach
                     @endif
                  @endif
                     <tr>
                        <th>Total</th>
                        <td></td>
                        <th class="text-right">{{ format_money($order->total) }}</th>
                     </tr>
                     @role('admin')
                     <tr>
                        <td>(-) Staff Payment</td>
                        <td></td>
                        <td class="text-right">{{ ($order->staff_payment_amount) ? format_money($order->staff_payment_amount) : 'Not set' }}</td>
                     </tr>
                     <tr>
                        <th>Profit</th>
                        <td></td>
                        <th class="text-right">{{ ($order->staff_payment_amount) ? format_money($order->total - $order->staff_payment_amount) : 'Staff payment is not set' }}</th>
                     </tr>
                  @endrole
               </table>
               <table class="table table-sm">
                  <thead>
                     <tr>
                        <th>Wallet payment</th>                        
                     </tr>
                  </thead>
                  <tbody>                    
                     <tr>
                        @if($walletPayment = $order->walletPayment())
                           <td>{{ $walletPayment->number }}</td>                        
                        @else
                           <td class="text-danger">No payment has been made</td>                        
                        @endif
                     </tr>
                     
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endif