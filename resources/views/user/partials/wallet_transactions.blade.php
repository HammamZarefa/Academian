<table id="table" class="table table-striped nowrap w-100">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Type</th>
            <th scope="col">Description</th>
            <th scope="col">Reference</th>
            <th scope="col">Amount</th>
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
