@extends('layouts.app')
@section('title', 'Job Applicants Profile')
@section('content')
<div class="container page-container">
   <div class="row mb-4">
      <div class="col-md-6">
         <h4>@lang('Job Applicants Profile')</h4>
      </div>
      <div class="col-md-6 text-right">
         <small>@lang('Applicant Number') : {{ $applicant->number }}</small>
      </div>
   </div>
   <div class="row">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <h5 class="h2">{{ $applicant->full_name }}</h5>
               <span class="badge ">
               @lang('Status'): <i>{{ $applicant->status->name }}</i>
               </span>
               <hr>
               <div class="text-muted"><i><b>@lang('About')</b></i></div>
               <p><?php echo $applicant->about; ?></p>
               <table class="table table-sm">
                  <tr>
                     <th class="col-lg-4">@lang('Resume')</th>
                     <td><a class="btn btn-primary btn-sm" href="{{ route('download_attachment', ['file' => $applicant->attachment]) }}"><i class="fas fa-file-download"></i> Download</a></td>
                  </tr>
                  <tr>
                     <th class="col-lg-4">@lang('Email')</th>
                     <td>{{ $applicant->email }}</td>
                  </tr>
                  <tr>
                     <th class="col-lg-4">@lang('Country')</th>
                     <td>{{ $applicant->country->name }}</td>
                  </tr>
                  <tr>
                     <th class="col-lg-4">@lang('Referral Source')</th>
                     <td>{{ $applicant->referral_source->name }}</td>
                  </tr>
                  <tr>
                     <th class="col-lg-4">@lang('Application Date')</th>
                     <td>{{ $applicant->created_at->format('d/m/Y') }}</td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         @include('applicant.partials.manage_status')
         <a href="#" id="invite_to_join" class="btn btn-success btn-sm btn-block text-white mb-4"><i class="fas fa-paper-plane"></i> @lang('Invite to join')</a>
         <a href="#" id="delete_profile" class="mb-4 text-danger"><i class="fas fa-minus-circle"></i> @lang('Delete')</a>
      </div>
   </div>
</div>

<form id="deleteProfileForm" method="post" action="{{ route('applicant_delete', $applicant->id) }}">
    @csrf
    @method('DELETE')
</form>
<form id="inviteToJoinForm" method="post" action="{{ route('applicant_invite_to_join', $applicant->id) }}">
   @csrf
</form>

@endsection
@push('scripts')
    <script>
        $(function() {

            $('select').select2({
                theme: 'bootstrap4',
            });

            $('#invite_to_join').on("click", function (e) {
                e.preventDefault();
                runSwal($("#inviteToJoinForm"), "Yes, Invite to join");
            });

            $('#delete_profile').on("click", function (e) {
                e.preventDefault();
                runSwal($("#deleteProfileForm"), "Yes, delete it!");
            });

            function runSwal(form, $confirmButtonText)
            {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: $confirmButtonText
            }).then((result) => {
                if (result.value) {
                form.submit();
                }
            });

            }

        });

    </script>
@endpush
