@extends('layouts.app')
@section('title', 'Pay with '. $data['gateway_name'])
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-md-12">
            <h3>Pay with {{ $data['gateway_name'] }}</h3>
            <hr>
        </div>
        <div class="col-md-6 d-none d-lg-block">
            <div class="checkout-image-cover">
                <img src="{{ asset('images/payment.svg') }}" class="img-fluid">
            </div>
        </div>
        <div class="col-md-6">
            @include('checkout.back_to_payment_options')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="h4">Total</h4>
                        <div class="h4">{{ format_money($data['total']) }}</div>
                    </div>
                    <hr>
                    @if($paymentMethod->instruction)
                    <div class="text-muted">
                        <div><b>Instructions</b></div>
                        {!! nl2br($paymentMethod->instruction) !!}
                    </div>
                    <br>
                    @endif
                    <form role="form" class="form-horizontal" enctype="multipart/form-data"
                        action="{{ route('process_pay_with_offline_method', $paymentMethod->slug) }}"
                        method="post" autocomplete="off">
                        @csrf
                        @if($paymentMethod->settings->requires_transaction_number)
                            <div class="form-group">
                                <label>{{ $paymentMethod->settings->reference_field_label }} <span
                                        class="required">*</span></label>
                                <input type="text"
                                    class="form-control {{ showErrorClass($errors,'reference') }}"
                                    name="reference" value="{{ old('reference') }}">
                                <div class="invalid-feedback">{{ showError($errors,'reference') }}
                                </div>
                            </div>
                        @endif
                        @if($paymentMethod->settings->requires_uploading_attachment)
                            <div class="form-group">
                                <label>{{ $paymentMethod->settings->attachment_field_label }} <span
                                        class="required">*</span></label>                                     
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="attachment">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="invalid-feedback d-block">
                                    {{ showError($errors,'attachment') }}</div>
                                    <div><small class="text-muted">Allowed file types: pdf,jpeg,png,zip, Maximum file size:10 MB</small></div>                                       
                            </div>
                        @endif
                        <button type="submit" class="btn btn-success btn-lg btn-block confirm-button"><i
                                class="fas fa-shopping-cart"></i> Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
