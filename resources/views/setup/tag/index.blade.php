@extends('setup.index')
@section('title', 'Tags')
@section('setting_page')

<style type="text/css">
   .toolbar {
    float: left;
}
  
</style>
@include('setup.partials.action_toolbar', [
 'title' => 'Tags', 
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create tag', 'url' => route("tags_create")]

 ])

<table id="table" class="table table-striped">
  <thead>
     <tr>       
        <th scope="col" style="width: 40%;">Name</th>                             
        <th scope="col" class="text-right">Action</th>
     </tr>
  </thead>
</table>
@endsection
@section('innerPageJS')
<script>
    $(function(){       

        var oTable = $('#table').DataTable({
          "bLengthChange": false,
            "dom": '<"toolbar">frtip',
            "bSort" : false,
            processing: true,
            serverSide: true,                           
            "ajax": {
                    "url": "{!! route('datatables_tags') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data": function ( d ) {
                        if ($("#showInactive").is(":checked")) 
                        {  
                          d.include_inactive_items = 1;
                        }               
                    }
            },
            columns: [      
                // { data: 'DT_RowIndex', name: 'DT_RowIndex' },                        
                {data: 'name', name: 'name'},                       
                {data: 'action', name: 'action', className: "text-right"},                
                
            ]
        });

   

        // var createButton = '<a class="btn btn-sm btn-primary" href="{{ route("tags_create") }}">New Tag</a>';

        // var toolbar = '<div class="d-flex flex-row">' + createButton + '</div>';

        // $("div.toolbar").html(toolbar);    

      
        $('#table').on('click', '.delete-item', function (e) {
               
            e.preventDefault();
            runSwal($(this).attr("href"));

        });

        $('#showInactive').change(function () {
            oTable.draw();
        });

    });   

    function runSwal($link_to_delete)
    {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
            window.location = $link_to_delete;
        }
      });

    }   
</script>
@endsection