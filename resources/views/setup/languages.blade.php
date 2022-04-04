@extends('setup.index')
@section('title', 'Languages Settings')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{
   route('patch_settings_currency') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Languages'])

    <div class="table-responsive--sm table-responsive">
        <table class="table table--light tabstyle--two custom-data-table white-space-wrap" id="myTable">
            <thead>
            <tr>
                <th scope="col">@lang('Key')
                </th>
                <th scope="col" class="text-left">
                    ar
                </th>

                <th scope="col" class="w-85">@lang('Action')</th>
            </tr>
            </thead>
            <tbody>

            @foreach($json as $k => $lang)
                <tr>
                    <td data-label="@lang('key')">{{$k}}</td>
                    <td data-label="@lang('Value')" class="text-left white-space-wrap">{{$lang}}</td>


                    <td data-label="@lang('Action')">
                        <a href="javascript:void(0)"
                           data-target="#editModal"
                           data-toggle="modal"
                           data-title="{{$k}}"
                           data-key="{{$k}}"
                           data-value="{{$lang}}"
                           class="editModal icon-btn ml-1"
                           data-original-title="@lang('Edit')">
                            <i class="la la-pencil"></i>
                        </a>

                        <a href="javascript:void(0)"
                           data-key="{{$k}}"
                           data-value="{{$lang}}"
                           data-toggle="modal" data-target="#DelModal"
                           class="icon-btn btn--danger ml-1 deleteKey"
                           data-original-title="@lang('Remove')">
                            <i class="la la-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> @lang('Add New')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <form action="{{route('language.store.key','ar')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="key" class="control-label font-weight-bold">@lang('Key')</label>
                            <input type="text" class="form-control form-control-lg " id="key" name="key" placeholder="@lang('Key')" value="{{old('key')}}">

                        </div>
                        <div class="form-group">
                            <label for="value" class="control-label font-weight-bold">@lang('Value')</label>
                            <input type="text" class="form-control form-control-lg" id="value" name="value" placeholder="@lang('Value')" value="{{old('value')}}">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary"> @lang('Save')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


   {{--<div class="form-group">--}}
      {{--<label>@lang('Currency Symbol') <span class="required">*</span></label>--}}
      {{--<input type="text" class="form-control {{ showErrorClass($errors, 'settings.currency_symbol')}}" name="currency_symbol" value="{{ old_set('currency_symbol', NULL, $rec) }}">--}}
      {{--<div class="invalid-feedback d-block">{{ showError($errors, 'currency_symbol') }}</div>--}}
   {{--</div>--}}
   {{--<div class="form-group">--}}
      {{--<label>@lang('Currency Code') <span class="required">*</span></label>--}}
      {{--<input type="text" class="form-control {{ showErrorClass($errors, 'settings.currency_code')}}" name="currency_code" value="{{ old_set('currency_code', NULL, $rec) }}">--}}
      {{--<div class="invalid-feedback d-block">{{ showError($errors, 'currency_code') }}</div>--}}
   {{--</div>--}}
   {{--<div class="form-group">--}}
      {{--<label>@lang('Digit Grouping') <span class="required">*</span></label>--}}
      {{--<?php--}}
         {{--echo form_dropdown('digit_grouping_method', $data['dropdowns']['list_of_digit_grouping_methods'], old_set('digit_grouping_method', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");--}}
         {{--?>--}}
         {{--<div class="invalid-feedback d-block">{{ showError($errors, 'digit_grouping_method') }}</div>--}}
   {{--</div>--}}
   {{--<div class="form-group">--}}
      {{--<label>@lang('Decimal Symbol') <span class="required">*</span></label>--}}
      {{--<?php--}}
         {{--echo form_dropdown('decimal_symbol', $data['dropdowns']['decimal_symbol'], old_set('decimal_symbol', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");--}}
         {{--?>--}}
   {{--</div>--}}
   {{--<div class="form-group">--}}
      {{--<label>@lang('Thousand Seperator') <span class="required">*</span></label>--}}
      {{--<?php--}}
         {{--echo form_dropdown('thousand_separator', $data['dropdowns']['thousand_separator'], old_set('thousand_separator', NULL, $rec) , "class='form-control selectPickerWithoutSearch'");--}}
         {{--?>--}}
   {{--</div>--}}
</form>
@endsection
{{--@section('innerPageJS')--}}
{{--<script>--}}
   {{--$(function() {--}}

       {{--$('.selectPickerWithoutSearch').select2({--}}
          {{--theme: 'bootstrap4',--}}
         {{--minimumResultsForSearch: -1--}}
      {{--});--}}

   {{--});--}}

{{--</script>--}}
{{--@endsection--}}
