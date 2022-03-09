@extends('layouts.app')
@section('title', 'Wallet Transactions')
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-md-6">
            <h4>Wallet Transactions</h4>
        </div>
        <div class="col-md-6 text-right">

        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-12">    
            <table id="table" class="table table-striped nowrap w-100">
                <thead>
                    <tr>
                        <th scope="col" data-priority="1">Date</th>
                        <th scope="col" data-priority="4">Number</th>
                        <th scope="col" data-priority="2">Type</th>
                        <th scope="col" data-priority="5">User</th>                        
                        <th scope="col">Description</th>
                        <th scope="col">Reference</th>                      
                        <th scope="col" data-priority="3">Amount</th>                    
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function () {

            $('select').select2({
                theme: 'bootstrap4',
            });

            var oTable = $('#table').DataTable({
                responsive: true,
                "bLengthChange": false,
                "bSort": false,
                searching: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{!! route('datatable_wallet_transactions') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },

                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'transactionable_type',
                        name: 'transactionable_type'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },  
                    {
                        data: 'description',
                        name: 'description'
                    },                                      
                    
                    {
                        data: 'reference',
                        name: 'reference'
                    },                      
                    {
                        data: 'amount',
                        name: 'amount',
                        className: "text-right"
                    }        
                    
                ]
            }).on('page.dt', function () {
                $('html, body').animate({
                    scrollTop: $(".dataTables_wrapper").offset().top
                }, 'slow');
            });


            $('#search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });

        });



    </script>
@endpush
