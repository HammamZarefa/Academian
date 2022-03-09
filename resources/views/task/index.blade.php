@extends('layouts.app')
@section('title', 'My Tasks')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>My Tasks</h4>
         <hr>
         @include('task.partials.statistics')
         <hr>         
      </div>

      <div class="col-md-8">
        <table id="tasks_table" class="w-100">
             <tr>
                  <th scope="col"></th>           
               </tr>
         </table>
      </div>

      <div class="col-md-4">
        @include('task.partials.search')     
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

        var oTable = $('#tasks_table').DataTable({
          "bLengthChange": false,
           searching: false,
            processing: true,
            serverSide: true, 
            sorting: false, 
            ordering : false,                              
            "ajax": {
                    "url": "{!! route('tasks_datatable') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                   
                    "data": function ( d ) {
                        
                        d.order_number            = $("input[name=order_number]").val();        
                        d.order_status_id         = $('select[name=order_status_id]').val();
                        d.dead_line               = $('select[name=dead_line]').val();               
                       
                        // etc
                    }
            },
            columns: [                              
                {data: 'task_html', name: 'task_html'},  
                // {data: 'customer', name: 'customer'},                                
                // {data: 'due_date', name: 'due_date'},               
                // {data: 'staff_payment_amount', name:'staff_payment_amount', className: "text-right"},
                
                
            ]
        }).on('page.dt', function() {
          $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
          }, 'slow');
        });


        $('#search-form').on('submit', function(e) {
          oTable.draw();
          e.preventDefault();
        });

    });      
</script>
@endpush