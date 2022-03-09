@extends('layouts.app')
@section('title', 'Browse Work')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>Browse Work</h4>        
          <hr>
      </div>
      <div class="col-md-8">
        <table id="tasks_table" class="w-100">
            <tr>
              <th scope="col">Item</th>             
           </tr>
         </table>
      </div>
       <div class="col-md-4">
        @include('task.partials.browse_work_search')     
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

        var oTable = $('#tasks_table').DataTable({
          "bLengthChange": false,
           searching: false,
            processing: true,
            serverSide: true,  
            sorting: false, 
            ordering : false,                           
            "ajax": {
                    "url": "{!! route('browse_work_datatable') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                   
                    "data": function ( d ) {
                        
                        d.service_id      = $("select[name=service_id]").val();             
                      
                    }
            },
            columns: [                              
                {data: 'task_html', name: 'task_html'}            
                
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