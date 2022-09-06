@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

    @include('setup.partials.action_toolbar', [
     'title' => (isset($coupon->id)) ? 'Edit coupon' : 'Create new coupon',
     'hide_save_button' => TRUE,
     'back_link' => ['title' => 'back to coupons', 'url' => route("coupons")],
    ])
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{ (isset($coupon->id)) ? route( 'coupon_update', $coupon->id) : route('coupon_store') }}"
          method="post" autocomplete="off">
        {{ csrf_field()  }}
        @if(isset($coupon->id))
            {{ method_field('PATCH') }}
        @endif

        <div class="form-group side-form">
            <div class="col-md-7 form} {{ showErrorClass($errors, 'form.*') }}">
                <label>@lang('Code') <span class="required">*</span></label>

                <input id="code" type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'code') }}"
                       name="code" value="{{Str::random(8)}}">
            </div>

        </div>
        <div class="form-group side-form">
            <div class="col-md-7">
                <label>
                    @lang('Amount')<span class="required">*</span>
                </label>
                <div class="input-group mb-3">
                    <input type="number" step="any" class="form-control" name="amount">
                    <div class="input-group-append">
                        <span class="input-group-text"></span>
                    </div>
                </div>
                <small class="form-text text-muted">@lang('Enter discount amount')</small>
                <div class="invalid-feedback d-block">{{ showError($errors, 'amount') }}</div>
            </div>
        </div>

        {{--<div class="form-group side-form"--}}
             {{--id="qty">--}}
            {{--<label>@lang('Quantity') <span class="required">*</span></label>--}}
            {{--<input type="text"--}}
                   {{--class="form-control form-control-sm "--}}
                   {{--name="quantity">--}}
            {{--<div class="invalid-feedback">{{ showError($errors, 'quantity') }}</div>--}}
        {{--</div>--}}

        <div class="form-group side-form" id="type">
            <label>@lang('Type') <span class="required">*</span></label>
            <div>
                FIXED <input name="type" type="radio" value="fixed" checked><br>
                Percent <input name="type" type="radio" value="percent">
            </div>
        </div>

        <div class="form-group side-form" id="minimumOrderQuantity">
            <label>@lang('Start At') </label>
            <input type="date" class="form-control form-control-sm" name="start_at">

            <label>@lang('Expired At')</label>
            <input type="date" class="form-control form-control-sm" name="expired_at">
        </div>

        <div class="form-group side-form">
            <div class="col-md-7">
                <div >
                    <input type="checkbox" class="-control-input" name="status">
                    <label class="custom-control" for="inactive">@lang('Active')</label>
                </div>
            </div>
        </div>
        <input type="submit" name="submit" class="btn btn-Create" value="Submit"/>
    </form>
@endsection
