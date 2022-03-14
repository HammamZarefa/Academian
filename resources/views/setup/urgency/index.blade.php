@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

<style type="text/css">
   .toolbar {
    float: left;
}

</style>
@include('setup.partials.action_toolbar', [
 'title' => 'Urgencies',
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create Urgency', 'url' => route("urgencies_create")]

 ])

<table id="table" class="table table-striped">
<thead>
   <tr>
      <th scope="col">@lang('Type')</th>
      <th scope="col" class="text-right">@lang('Percentage of base price of a service')</th>
      <th scope="col">@lang('Status')</th>
      <th scope="col" class="text-right">@lang('Action')</th>
   </tr>
</thead>
</table>
@endsection
@push('scripts')
<script>
    $(function(){

        var oTable = $('#table').DataTable({
          "bLengthChange": false,
            "dom": '<"toolbar">frtip',
            "bSort" : false,
            processing: true,
            serverSide: true,
            "ajax": {
                    "url": "{!! route('datatable_urgencies') !!}",
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
                {data: 'type', name: 'type'},
                {data: 'percentage', name: 'percentage', className: "text-right"},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', className: "text-right"},

            ]
        });

        var checkbox = '<div class="form-check" style="margin-right:20px;">';
        checkbox +='<input class="form-check-input" type="checkbox" value="1" id="showInactive">';
        checkbox +='<label class="form-check-label" for="showInactive">';
        checkbox +='Include Inactive items';
        checkbox +='</label>';
        checkbox +='</div>';

        var createButton = '<a class="btn btn-sm btn-primary" href="{{ route("urgencies_create") }}">New Urgency</a>';

        var toolbar = '<div class="d-flex flex-row">' + checkbox + '</div>';

        $("div.toolbar").html(toolbar);

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
@endpush
