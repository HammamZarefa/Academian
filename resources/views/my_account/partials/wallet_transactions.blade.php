<h4>My Transactions</h4>
<table id="table" class="table table-striped nowrap w-100">
    <thead>
        <tr>
            <th scope="col" data-priority="1">Date</th>
            <th scope="col" data-priority="2">Type</th>
            <th scope="col">Description</th>
            <th scope="col">Reference</th>
            <th scope="col" data-priority="3">Amount</th>
            <th scope="col" data-priority="4">Balance</th>
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
            searching: false,
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{!! route('my_wallet_transactions') !!}",
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
                },
                {
                    data: 'balance',
                    name: 'balance',
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
