@extends('layouts.app')
@section('title', 'Activity Log')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
        <h4>Activity Log</h4>         
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('activity_log_delete') }}" class="btn btn-outline-danger">
          <i class="far fa-trash-alt"></i> Delete Logs
        </a>
      </div>
      <div class="col-md-12">
         <br>         
         <table id="orders_table" class="table table-striped">
            <thead>
               <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Causer</th>                 
                  <th scope="col">Description</th>                  
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

        var oTable = $('#orders_table').DataTable({
          "bLengthChange": false,
          "bSort" : false,
           searching: false,
            processing: true,
            serverSide: true,                           
            "ajax": {
                    "url": "{!! route('datatable_activity_log') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                  
          
            },
            columns: [
                {data: 'date', name: 'date'},  
                {data: 'causer_name', name: 'causer_name'},                  
                {data: 'description', name: 'description'},            
                
            ]
        });


    });      
</script>
@endpush