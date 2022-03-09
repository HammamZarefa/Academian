@extends('layouts.app')
@section('title', 'Pay with '. $data['gateway_name'])
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="col-md-12">
            <h3>Pay with {{ $data['gateway_name'] }}</h3>
            @php
                if($errors->has('payment_method_nonce'))
                {
                echo $errors->first('payment_method_nonce') ;
                }
            @endphp
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
                    <div id="dropin-wrapper">
                        <div id="checkout-message"></div>
                        <div id="dropin-container"></div>
                        <button style="display: none;" id="submit-button" class="btn btn-success btn-lg btn-block"><i
                                class="fas fa-shopping-cart"></i> Confirm Payment</button>
                    </div>
                    <div class="text-center" id="loading">Please wait ...</div>
                </div>
            </div>
        </div>
    </div>
    <form id="payment-form" method="POST" action="{{ route('braintree_process') }}">
        @csrf
        <input id="nonce" name="payment_method_nonce" type="hidden" />
        <input id="payment_method" name="payment_method" type="hidden" />
    </form>
</div>
@endsection

@push('scripts')
<script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.min.js"></script>

    <script>      

        var submitButton = $('#submit-button');
        var loading = $('#loading');
        var nonce = $('#nonce');

        config = {
            authorization: "{{ $data['client_token'] }}",
            container: '#dropin-container'
        };
        
        <?php if($data['enable_paypal'] == true) {?>
        config.paypal = {
            flow: 'vault'
        };
        <?php } ?>

        braintree.dropin.create(config, function (createErr, dropinInstance) {

            loading.hide();
            if (createErr) {
                showError("Something went wrong, please try again later");
                return;
            }

            $('.braintree-toggle').on("click", function (e) {
                dropinInstance.clearSelectedPaymentMethod();
                submitButton.hide();
                nonce.val("");
            });

            submitButton.on("click", function (e) {
                dropinInstance.requestPaymentMethod(function (reqError, payload) {
                    if (reqError) {
                        showError("Something went wrong, please try again later");
                        return;
                    }
                    nonce.val(payload.nonce);
                    $('#dropin-wrapper').hide();
                    $('#payment-form').submit();
                    loading.show();
                });
            });

            dropinInstance.on('paymentMethodRequestable', function (event) {

                if (event.type == 'PayPalAccount' && event.paymentMethodIsSelected == false) {
                    dropinInstance.clearSelectedPaymentMethod();
                    submitButton.hide();
                } else {
                    submitButton.show();
                }
            });

            dropinInstance.on('noPaymentMethodRequestable', function () {
                submitButton.hide();
            });

        });

        function showError(message) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                text: message
            });
        }

    </script>

@endpush
