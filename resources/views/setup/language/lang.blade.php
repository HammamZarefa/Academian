@extends('setup.index')
@section('panel')

    dfgdgdfgdgf
    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<div class="card b-radius--10 ">--}}
                {{--<div class="card-body p-0">--}}
                    {{--<div class="table-responsive--sm table-responsive">--}}
                        {{--<table class="table table--light tabstyle--two custom-data-table">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th scope="col">@lang('Name')</th>--}}
                                {{--<th scope="col">@lang('Code')</th>--}}
                                {{--<th scope="col">@lang('Default')</th>--}}
                                {{--<th scope="col">@lang('Actions')</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@forelse ($languages as $item)--}}
                                {{--<tr>--}}
                                    {{--<td data-label="@lang('Name')">{{__($item)}}--}}
                                    {{--</td>--}}
                                    {{--<td data-label="@lang('Code')"><strong>{{ __($item) }}</strong></td>--}}
                                    {{--<td data-label="@lang('Status')">--}}
                                        {{--@if($item=='en')--}}
                                            {{--<span class="text--small badge font-weight-normal badge--success">@lang('Default')</span>--}}
                                        {{--@else--}}
                                            {{--<span class="text--small badge font-weight-normal badge--warning">@lang('Selectable')</span>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td data-label="@lang('Action')">--}}
                                        {{--<a href="{{route('language.key', $item)}}" class="icon-btn btn--success" data-toggle="tooltip" data-original-title="@lang('Translate')">--}}
                                            {{--<i class="la la-code"></i>--}}
                                        {{--</a>--}}
                                        {{--<a href="javascript:void(0)" class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip" data-url="{{ route('language.manage.update', $item)}}" data-lang="{{ json_encode($item) }}" data-icon="">--}}
                                            {{--<i class="la la-edit"></i>--}}
                                        {{--</a>--}}

                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@empty--}}
                                {{--<tr>--}}
                                    {{--<td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>--}}
                                {{--</tr>--}}
                            {{--@endforelse--}}
                            {{--</tbody>--}}
                        {{--</table><!-- table end -->--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div><!-- card end -->--}}
        {{--</div>--}}
    {{--</div>--}}



    {{-- NEW MODAL --}}
    {{--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> @lang('Add New Language')</h4>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                {{--</div>--}}
                {{--<form class="form-horizontal" method="post" action="{{ route('language.manage.store')}}" enctype="multipart/form-data">--}}
                    {{--@csrf--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="form-row form-group">--}}
                            {{--<label class="font-weight-bold ">@lang('Language Name') <span class="text-danger">*</span></label>--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<input type="text" class="form-control has-error bold " id="code" name="name" placeholder="@lang('e.g. Japaneese, Portuguese')" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-row form-group">--}}
                            {{--<label class="font-weight-bold">@lang('Language Code') <span class="text-danger">*</span></label>--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<input type="text" class="form-control has-error bold " id="link" name="code" placeholder="@lang('e.g. jp, pt-br')" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-row form-group">--}}
                            {{--<div class="col-md-6  d-none">--}}
                                {{--<label class="font-weight-bold">@lang('Text Direction') <span class="text-danger">*</span></label>--}}
                                {{--<select name="text_align" class="form-control">--}}
                                    {{--<option value="0">@lang('Left to Right')</option>--}}
                                    {{--<option value="1">@lang('Right to Left')</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-12">--}}
                                {{--<label for="inputName" class="">@lang('Default Language') <span class="text-danger">*</span></label>--}}
                                {{--<input type="checkbox" data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('SET')" data-off="@lang('UNSET')" name="is_default">--}}
                            {{--</div>--}}

                        {{--</div>--}}

                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>--}}
                        {{--<button type="submit" class="btn btn--primary" id="btn-save" value="add">@lang('Save')</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{-- EDIT MODAL --}}
    {{--<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-share-square"></i>@lang('Edit Language')</h4>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                {{--</div>--}}
                {{--<form method="post" enctype="multipart/form-data">--}}
                    {{--@csrf--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="form-row">--}}
                            {{--<label for="inputName" class="font-weight-bold">@lang('Language Name') <span class="text-danger">*</span></label>--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<input type="text" class="form-control has-error bold" id="code" name="name" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group mt-2">--}}
                            {{--<label for="inputName" class="font-weight-bold">@lang('Default Language') <span class="text-danger">*</span></label>--}}
                            {{--<input type="checkbox" data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('SET')" data-off="@lang('UNSET')" name="is_default">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>--}}
                        {{--<button type="submit" class="btn btn--primary" id="btn-save" value="add">@lang('Update')</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{-- DELETE MODAL --}}
    {{--<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h4 class="modal-title" id="myModalLabel">@lang('Remove Language')</h4>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                {{--</div>--}}
                {{--<form method="post" action="">--}}
                    {{--@csrf--}}
                    {{--<input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">--}}
                    {{--<div class="modal-body">--}}
                        {{--<p class="text-muted">@lang('Are you sure you want to Delete?')</p>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>--}}
                        {{--<button type="submit" class="btn btn--danger deleteButton">@lang('Delete')</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection


{{--@push('breadcrumb-plugins')--}}
    {{--<a class="btn btn-sm btn--primary box--shadow1 text-white text--small" data-toggle="modal" data-target="#myModal"><i class="fa fa-fw fa-plus"></i>@lang('Add New Language')</a>--}}
{{--@endpush--}}

{{--@push('script')--}}
    {{--<script>--}}
        {{--(function($){--}}
            {{--"use strict";--}}
            {{--$('.editBtn').on('click', function () {--}}
                {{--var modal = $('#editModal');--}}
                {{--var url = $(this).data('url');--}}
                {{--var icon = $(this).data('icon');--}}
                {{--var lang = $(this).data('lang');--}}

                {{--modal.find('form').attr('action', url);--}}
                {{--modal.find('.language-icon').attr('src',icon);--}}
                {{--modal.find('input[name=name]').val(lang.name);--}}
                {{--modal.find('select[name=text_align]').val(lang.text_align);--}}
                {{--if (lang.is_default == 1) {--}}
                    {{--modal.find('input[name=is_default]').bootstrapToggle('on');--}}
                {{--} else {--}}
                    {{--modal.find('input[name=is_default]').bootstrapToggle('off');--}}
                {{--}--}}
                {{--modal.modal('show');--}}
            {{--});--}}

            {{--$('.deleteBtn').on('click', function () {--}}
                {{--var modal = $('#deleteModal');--}}
                {{--var url = $(this).data('url');--}}

                {{--modal.find('form').attr('action', url);--}}
                {{--modal.modal('show');--}}
            {{--});--}}
        {{--})(jQuery);--}}
    {{--</script>--}}
{{--@endpush--}}
