@extends('layouts.app')
@section('title', $data['entity'])
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-6">
         <h4>@lang('List of') {{ $data['entity'] }}</h4>
         <br>
      </div>
      <div class="col-md-6">
         @if(in_array($data['type'],['admin', 'staff']))
         {{--<a href="{{ route('user_invitation', ['type' => $data['type']])}}" class="btn btn-success float-md-right">--}}
         {{--<i class="fas fa-paper-plane"></i>--}}
         {{--Invite {{ $data['entity_singular'] }}--}}
         {{--</a>--}}
         @endif
      </div>
      <div class="clearfix"></div>
      <div class="col-md-4">
         @include('user.partials.search')
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
   </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){

      $('.multSelectpicker').select2({
        theme: 'bootstrap4',
      });


      var oTable = $('#table').DataTable({
        "bLengthChange": false,
          searching: false,
          processing: true,
          serverSide: true,
          "ordering": false,
          "ajax": {
                  "url": "{!! route('datatable_users', ['type' => $data['type'] ]) !!}",
                  "type": "POST",
                  'headers': {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  "data": function ( d ) {
                      d.search = $("input[name=search]").val();

                      if($("#inactive").prop("checked"))
                      {
                        d.inactive = 1;
                      }

                      var tags = $("#tag_id").val();

                      if(tags)
                      {
                        d.tags = tags;
                      }

                  }
          },
          columns: [
              {data: 'user_html', name: 'user_html'}
          ]
      }).
      on('page.dt', function() {
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

