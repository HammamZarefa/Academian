<table id="table" class="w-100">
   <thead>
      <tr>
         <th scope="col"></th>
      </tr>
   </thead>
</table>
@section('innerJs')
<script>
    $(function(){

        $('select').select2({
              theme: 'bootstrap4',
        });

        var oTable = $('#table').DataTable({
          "bLengthChange": false,
          "bSort": false,
           searching: false,
            processing: true,
            serverSide: true,                           
            "ajax": {
                    "url": "{!! route('orders_datatable', ['staff_id' => $user->id]) !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }               
                    
            },
            columns: [ 
                {data: 'customer_html', name: 'customer_html'},           
                
            ]
        });


        $('#search-form').on('submit', function(e) {
          oTable.draw();
          e.preventDefault();
        });

    });      
</script>
@endsection