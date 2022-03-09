<table id="table" class="w-100">
    <thead>
        <tr>
            <th scope="col"></th>
        </tr>
    </thead>
</table>
@section('innerJs')
<script>
    $(function () {

        var oTable = $('#table').DataTable({
            "bLengthChange": false,
            searching: false,
            processing: true,
            serverSide: true,
            sorting: false,
            ordering: false,
            "ajax": {
                "url": "{!! route('orders_datatable', ['customer_id' => $user->id]) !!}",
                "type": "POST",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }

            },
            columns: [{
                    data: 'customer_html',
                    name: 'customer_html'
                }

            ]
        });
    });
</script>
@endsection
