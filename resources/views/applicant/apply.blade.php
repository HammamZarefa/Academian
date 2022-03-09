@extends('layouts.app')
@section('title', settings('writer_application_page_title'))
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-lg-12">
        <h1 class="h3">{{ settings('writer_application_page_title') }}</h1>
            <hr>
            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class', 'alert-primary') }} alert-dismissible fade show"
                    role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-lg-7">
            <div class="card shadow zindex-100 p-4">
               <div>{!! settings('writer_application_page_content') !!}</div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow zindex-100 p-4">
                <div class="card-body" id="authentication">
                    <div class="mb-3">
                        <h6 class="h3 writer-application-form-title">{!! settings('writer_application_form_title') !!}</h6>
                    </div>
                    @if(settings('writer_application_form_subtitle'))
                        <small class="text-muted">{!! settings('writer_application_form_subtitle') !!}</small>
                    @endif
                    <form class="mt-4" method="POST"
                        action="{{ route('store_writer_application') }}" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group">
                            <label for="first_name">{{ __('First Name') }} <span
                                    class="required">*</span></label>
                            <input id="first_name" type="text"
                                class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                value="{{ old('first_name') }}" autocomplete="first_name">
                            @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">{{ __('Last Name') }} <span
                                    class="required">*</span></label>
                            <input id="last_name" type="text"
                                class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                value="{{ old('last_name') }}" autocomplete="last_name">
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group @error('email') is-invalid @enderror">
                            <label>{{ __('E-Mail Address') }} <span
                                    class="required">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email"
                            value="{{ old('email') }}"
                                autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group mb-4 @error('country_id') is-invalid @enderror">
                            <label>{{ __('Country') }} <span class="required">*</span></label>
                            <?php echo form_dropdown("country_id", $data['countries'], old('country_id'), "class='form-control form-control-sm  selectpicker'") ?>
                            @error('country_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4 @error('referral_source_id') is-invalid @enderror">
                            <label>{{ __('How did you hear about us ?') }} <span
                                    class="required">*</span></label>
                            <?php echo form_dropdown("referral_source_id", $data['referral_sources'], old('referral_source_id'), "class='form-control form-control-sm  selectpicker'") ?>
                            @error('referral_source_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group @error('about') is-invalid @enderror">
                            <label>Brief summary about you <span class="text-muted">(optional)</span></label>
                            <textarea rows="4" class="form-control"
                                name="about">{{ old('about') }}</textarea>
                            @error('about')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group @error('resume') is-invalid @enderror">
                            <label>Resume (PDF file) <span class="required">*</span> </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="resume" name="resume" />
                                <label class="custom-file-label" for="resume">Choose file</label>
                            </div>
                            @error('resume')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-icon rounded-pill">
                                {{ __('Submit') }}
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('select').select2({
                theme: 'bootstrap4'
            });
        });

    </script>
@endpush
