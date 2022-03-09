@extends('layouts.app')
@section('title', 'Bills')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
        <h4>Bills</h4>         
      </div>
      <div class="col-md-6 text-right">
        <span class="{{ ($data['statistics']['unpaid']['total'] > 0 ) ? 'text-danger' : 'text-success' }} ">
            Unpaid Balance: {{ format_money($data['statistics']['unpaid']['total']) }}
            </span>
      </div>
      <div class="col-md-12">
         <br>         
         @include('bill.partials.search')
         <table id="orders_table" class="table table-striped">
            <thead>
               <tr>
                  <th scope="col">Number</th>
                  <th scope="col">Staff Invoice Number</th>
                  <th scope="col">Date</th>
                  <th scope="col" class="w-25">From</th>                  
                  <th scope="col">Status</th>
                  <th scope="col">Amount</th>
               </tr>
            </thead>
         </table>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){

        $('select').select2({
              theme: 'bootstrap4',
        });

        var oTable = $('#orders_table').DataTable({
          "bLengthChange": false,
          "bSort" : false,
           searching: false,
            processing: true,
            serverSide: true,                           
            "ajax": {
                    "url": "{!! route('datatable_bills') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                   
                    "data": function ( d ) {
                        
                        d.number              = $("input[name=number]").val();
                        d.from                  = $('select[name=from]').val();
                        d.status               = $('select[name=bill_status_list]').val();
                       
                       
                        // etc
                    }
            },
            columns: [ 
                {data: 'number', name: 'number'},   
                {data: 'staff_invoice_number', name: 'staff_invoice_number'},            
                {data: 'date', name: 'date'},  
                {data: 'from', name: 'from'},                                
                {data: 'status', name: 'status'},            
                {data: 'total', name:'total', className: "text-right"},
                
                
            ]
        });


        $('#search-form').on('submit', function(e) {
          oTable.draw();
          e.preventDefault();
        });

    });      
</script>
@endpush