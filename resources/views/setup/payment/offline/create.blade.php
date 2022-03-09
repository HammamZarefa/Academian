@extends('setup.index')
@section('title', 'Offline Payment Methods')
@section('setting_page')

@include('setup.partials.action_toolbar', [
'title' => (isset($method->id)) ? 'Edit offline payment method' : 'Create new offline payment method',
'hide_save_button' => TRUE,
'back_link' => ['title' => 'back to offline payment methods', 'url' => route("offline_payment_methods")],
])
<form role="form" class="form-horizontal" enctype="multipart/form-data"
    action="{{ (isset($method->id)) ? route( 'offline_payment_method_update', $method->id) : route('offline_payment_method_store') }}"
    method="post" autocomplete="off">
    {{ csrf_field() }}
    @if(isset($method->id))
        {{ method_field('PATCH') }}
    @endif

    <div class="form-group">
        <label>Name <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}"
            name="name" value="{{ old_set('name', NULL, $method) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'name') }}</div>
    </div>


    <div class="form-group">
        <label>Description <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'description') }}"
            name="description" value="{{ old_set('description', NULL, $method) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'description') }}</div>
    </div>


    <div class="form-group">
        <label>Message to display after submitting the payment request <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'success_message') }}"
            name="success_message" value="{{ old_set('success_message', NULL, $method) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'success_message') }}</div>
    </div>

    <div class="form-group">
        <label>Instruction to customer <small class="text-muted">(e.g bank name, account number, swift code etc. )</small></label>
        <textarea
            class="form-control form-control-sm {{ showErrorClass($errors, 'instruction') }}"
            name="instruction">{{ old_set('instruction', NULL, $method) }}</textarea>
        <div class="invalid-feedback d-block">{{ showError($errors, 'instruction') }}</div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="requires_transaction_number"
                name="requires_transaction_number" value="1"
                {{ old_set('requires_transaction_number', NULL, $method->settings) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="requires_transaction_number">Requires Evidence / Transaction
                number</label>
        </div>
    </div>

    <div class="form-group reference_field_label"
        style="{{ hideElementIfApplicable('requires_transaction_number', $method->settings) }}">
        <label>Field name to display for entering transaction number <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'reference_field_label') }}"
            name="reference_field_label"
            value="{{ old_set('reference_field_label', NULL, $method->settings) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'reference_field_label') }}
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="requires_uploading_attachment"
                name="requires_uploading_attachment" value="1"
                {{ old_set('requires_uploading_attachment', NULL, $method->settings) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="requires_uploading_attachment">Requires Uploading
                attachment</label>
        </div>
    </div>

    <div class="form-group attachment_field_label"
        style="{{ hideElementIfApplicable('requires_uploading_attachment', $method->settings) }}">
        <label>Field name to display for attachment uploading <span class="required">*</span></label>
        <input type="text"
            class="form-control form-control-sm {{ showErrorClass($errors, 'attachment_field_label') }}"
            name="attachment_field_label"
            value="{{ old_set('attachment_field_label', NULL, $method->settings) }}">
        <div class="invalid-feedback d-block">{{ showError($errors, 'attachment_field_label') }}
        </div>
    </div>



    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1"
                {{ old_set('inactive', NULL, $method) ? 'checked="checked"' : '' }}>
            <label class="custom-control-label" for="inactive">Inactive</label>
        </div>
    </div>
    <input type="submit" name="submit" class="btn btn-success" value="Submit" />
</form>
@endsection

@section('innerPageJS')
<script>
    $(function () {

        $('#requires_transaction_number').on('click', function () {

            if (this.checked) {
                $('.reference_field_label').show();
            } else {
                $('.reference_field_label').hide();
            }

        });

        $('#requires_uploading_attachment').on('click', function () {

            if (this.checked) {
                $('.attachment_field_label').show();
            } else {
                $('.attachment_field_label').hide();
            }

        });


    });

</script>
@endsection
