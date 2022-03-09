@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="container page-container">
   @if(Session::has('checkout_process'))
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{!! session('checkout_process') !!}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   @if($data['order_count'] > 0)
   <div class="row">
      <div class="col-md-6">
         <h4>My Orders</h4>
      </div>
      <div class="col-md-6">
         <a href="{{ route('order_page') }}" class="btn btn-success float-md-right"> <i class="fas fa-plus"></i> New Order</a>
      </div>
      <div class="col-md-12">
         <hr>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-md-8">
         <table id="orders_table" class="w-100">
            <thead>
               <tr>
                  <th scope="col"></th>
               </tr>
            </thead>
         </table>
      </div>
      <div class="col-md-4">
         @include('my_account.partials.order_search')
      </div>
   </div>  
   @else
   <div class="row">
      <div class="offset-md-3 col-md-6 place-first-order">
         <div class="d-flex flex-column justify-content-center">
            <img class="img-fluid" src="{{ asset('images/order.svg') }}">
            <h5 class="text-center">Place your first order</h5>
            <br><br><br>
            <a href="{{ route('order_page') }}" class="btn btn-success btn-lg btn-block">Order Now</a>
         </div>
      </div>
   </div>
   @endif
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

        var oTable = $('#orders_table').DataTable({
          "bLengthChange": false,
           searching: false,
            processing: true,
            serverSide: true,
            sorting: false, 
            ordering : false,                              
            "ajax": {
                    "url": "{!! route('my_orders_datatable') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                   
                    "data": function ( d ) {          
                        d.order_number            = $("input[name=order_number]").val();                    
                        d.order_status_id         = $('select[name=order_status_id]').val();
                        d.dead_line               = $('select[name=dead_line]').val();
                        d.show_archived           = ($('input[name=show_archived]').is(':checked')) ? 1 : null;                                               
                        d.show_by_nearest_due_date  = ($('input[name=show_by_nearest_due_date]').is(':checked')) ? 1 : null;                       
                        
                    }
            },
            columns: [                              
                {data: 'customer_html', name: 'customer_html'},  
   
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