@extends('layouts.app')
@section('title', 'Payments')
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-md-6">
            <h4>@lang('Payments')</h4>
        </div>
        <div class="col-md-6 text-right">

        </div>
        <div class="col-md-12">
            <table id="orders_table" class="table table-striped nowrap w-100">
                <thead>
                    <tr>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col">@lang('Number')</th>
                        <th scope="col">@lang('From')</th>
                        <th scope="col">@lang('Method')</th>
                        <th scope="col">@lang('Reference')</th>
                        <th scope="col">@lang('Amount')</th>
                        <th scope="col">@lang('Attachment')</th>
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

            var oTable = $('#orders_table').DataTable({
                responsive: true,
                "bLengthChange": false,
                "bSort": false,
                searching: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{!! route('datatable_payments') !!}",
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
                        data: 'from',
                        name: 'from'
                    },
                    {
                        data: 'method',
                        name: 'method'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },

                    {
                        data: 'amount',
                        name: 'amount',
                        className: "text-right"
                    },
                    {
                        data: 'attachment',
                        name: 'attachment',
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
