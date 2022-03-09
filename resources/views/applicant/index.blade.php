@extends('layouts.app')
@section('title', 'Job Applicants')
@section('content')
<div class="container page-container">
   <div class="row mb-4">
      <div class="col-md-6">
         <h4>Job Applicants</h4>
      </div>
      <div class="col-md-6 text-right">
      </div>
   </div>
   <div class="row">
      <div class="col-md-4">
         @include('applicant.partials.search')
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
        $(function() {

            $('select').select2({
                theme: 'bootstrap4',
            });

            var oTable = $('#table').DataTable({
                responsive: true,
                "bLengthChange": false,
                "bSort": false,
                searching: false,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{!! route('datatable_job_applicannts') !!}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data": function(d) {
                        d.general_text_search = $("input[name=general_text_search]").val();
                        d.applicant_status_id = $('select[name=applicant_status_id]').val();
                        d.referral_source_id = $('select[name=referral_source_id]').val();                        
                    }
                },
                columns: [{
                        data: 'applicant_html',
                        name: 'applicant_html'
                    }                    
                ]
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });

        });

    </script>
@endpush
