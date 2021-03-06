<h4>@lang('My Payments')</h4>
<table id="table" class="table table-striped nowrap w-100">
    <thead>
        <tr>
            <th scope="col" data-priority="1">@lang('Date')</th>
            <th scope="col">@lang('Number')</th>
            <th scope="col" data-priority="2">@lang('Method')</th>
            <th scope="col">@lang('Reference')</th>
            <th scope="col" data-priority="3">@lang('Amount')</th>
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
                "url": "{!! route('my_payments') !!}",
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
