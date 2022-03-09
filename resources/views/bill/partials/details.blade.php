<div class="document-parent-container">
<div class="document-container">
   <!-- Badge overlay DIV -->
   <div class="badge-overlay">              
      <span class="top-left badge {{ ($bill->paid) ? 'green' : 'red' }}">
      {{ ($bill->paid) ? 'Paid' : 'Unpaid' }}
      </span>
   </div>
   <!-- Badge overlay DIV -->
   <div class="row">
      <div class="col-md-6">
         <br><br>
         <h4 class="bold">
            <span>{{ $bill->staff_invoice_number }}</span>
         </h4>
         <address>
            <div><b>{{ $bill->name }}</b></div>
            <div>{{ $bill->address }}
         </address>
         </div>
         <div class="col-md-6 text-right">
            <div><b>Bill To:</b></div>
            <span class="bold">{{ settings('company_name') }}:</span>
            <address>{{ settings('company_address') }}</address>
            <p class="no-mbot">
               <span class="bold">
               Date:  {{ sql2date($bill->created_at) }}
               </span>
            </p>
         </div>
      </div>
      <br><br>
      <div class="row">
         <div class="col-md-12">
             <table class="table">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th class="description text-left" width="50%">Item</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">Sub Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($bill->items as $key=>$item) 
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="description text-left">
                           <strong>{{ $item->order->title }}</strong>
                           <br>
                           <span class="text-color-light">{{ $item->order->service->name }}</span>
                        </td>
                        <td class="text-right">{{ $item->order->number_of_pages }}</td>
                        <td class="text-right">{{ format_money($item->total) }}</td>
                        <td class="text-right">{{ format_money($item->total) }}</td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
         </div>
         <div class="col-md-4 offset-md-8">
            <table class="table text-right">
               <tbody>
                  <tr>
                     <td><span class="bold">Total</span>
                     </td>
                     <td class="subtotal">{{ format_money($bill->total) }}</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      @if($bill->note)
      <div class="row">
         <div class="col-md-12">
            <div><b>Note</b></div>
            {{ $bill->note }}
         </div>
      </div>
      @endif
   </div>
</div>