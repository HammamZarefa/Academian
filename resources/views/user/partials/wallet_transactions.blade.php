<table id="table" class="table table-striped nowrap w-100">
    <thead>
        <tr>
            <th scope="col">@lang('Date')</th>
            <th scope="col">@lang('Type')</th>
            <th scope="col">@lang('Description')</th>
            <th scope="col">@lang('Reference')</th>
            <th scope="col">@lang('Amount')</th>
        </tr>
    </thead>
</table>

@section('innerJs')
<script>
    $(function () {

        var oTable = $('#table').DataTable({
            responsive: true,
            "bLengthChange": false,
            "bSort": false,
            searching: true,
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{!! route('datatable_wallet_transactions', ['user_id' => $user->id]) !!}",
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
                    data: 'transactionable_type',
                    name: 'transactionable_type'
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


    });

</script>
@endsection
