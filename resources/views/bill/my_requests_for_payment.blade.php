@extends('layouts.app')
@section('title', 'My payment requests')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
         <h4>My payment requests</h4>
      </div>
      <div class="col-md-6">
         <h5 class="text-right">Balance Due: {{ format_money($data['uncleared_payment_total']) }}</h5>
      </div>
      <div class="col-md-12">
         <hr>
      </div>
      <div class="col-md-8">
         <table id="table" class="w-100">
            <thead>
               <tr>
                  <th scope="col"></th>
               </tr>
            </thead>
         </table>
      </div>
      <div class="col-md-4">
         @include('bill.partials.my_payment_request_search')
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){   

      $('.selectpicker').select2({
        theme: 'bootstrap4',
        escapeMarkup: function(markup) {
            return markup;
         },
         templateResult: function (data, container) {               
            return '<span class="select2-option">'+data.text+'</span>';
         }
      });

        var oTable = $('#table').DataTable({
          "bLengthChange": false,
           searching: false,
            processing: true,
            serverSide: true, 
            sorting: false, 
            ordering : false,                              
            "ajax": {
                    "url": "{!! route('datatable_my_requests_for_payment') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data": function ( d ) {
                      d.status = $("select[name=status]").val();
                      d.number = $("input[name=number]").val();

                       
                     
                  }                 

            },
            columns: [    
                {data: 'bill_html', name: 'bill_html'}     
             
                
            ]
        });

    $('#search-form').on('submit', function(e) {
      oTable.draw();
      e.preventDefault();
    });   

});      
</script>
@endpush