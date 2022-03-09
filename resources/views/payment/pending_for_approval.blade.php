@extends('layouts.app')
@section('title', 'Payments pending for approval')
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-md-6">
            <h4>Payments pending for approval</h4>
        </div>
        <div class="col-md-6 text-right">

        </div>
        <div class="col-md-12">    
            <table id="orders_table" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">From</th>
                        <th scope="col">Method</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Attachment</th>
                        <th scope="col">Action</th>
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
                    "url": "{!! route('datatable_pending_payment_approval') !!}",
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
                        data: 'from',
                        name: 'from'
                    },
                    {
                        data: 'method',
                        name: 'method'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: "text-right"
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },
                    {
                        data: 'payment_reason',
                        name: 'payment_reason'
                    },
                    {
                        data: 'attachment',
                        name: 'attachment'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-right"
                    }
                ]
            });       

        });


        $(document).on("click", '.approve', function (e) {

            e.preventDefault();
            var href = $(this).attr('href');
            swal(href, 'Yes, Approve');

        });

        $(document).on("click", '.disapprove', function (e) {

            e.preventDefault();
            var href = $(this).attr('href');
            swal(href, 'Yes, Disapprove');

        });


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });


        function swal(url, $confirmButtonText) {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: $confirmButtonText,
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                }
            })

        }

    </script>
@endpush
