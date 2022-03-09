@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
         <h4>Your Notifications</h4>
         <br>
      </div>
      <div class="col-md-6">
        
      </div>
  
      <div class="col-md-12">
         <table id="table" class="table table-stripe">
            <thead>
               <tr>
                  <th>Description</th>
                  <th>Status</th>    
                  <th>Time</th>   

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

        
      var oTable = $('#table').DataTable({
        "bLengthChange": false,
          searching: false,
          processing: true,
          serverSide: true,    
          "ordering": false,            
          "ajax": {
                  "url": "{!! route('datatable_notifications') !!}",
                  "type": "POST",
                  'headers': {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },                   
                  
          },
          columns: [
              {data: 'description', name: 'description'},
              {data: 'status', name: 'status'},
              {data: 'created_at', name: 'created_at'},         
          ]
      }).
      on('page.dt', function() {
          $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
          }, 'slow');
        });

  

    });      
</script>
@endpush
   
