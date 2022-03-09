<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessOfflinePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $settings = $this->paymentMethod->settings;

        if ($settings->requires_transaction_number == true) {
            $rules['reference'] = 'required';
        }
        if ($settings->requires_uploading_attachment == true) {
            $rules['attachment'] = 'required|mimes:pdf,jpeg,png,zip|max:10000';
        }
        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        $attributeNames = [];
        $settings = $this->paymentMethod->settings;

        if ($settings->requires_transaction_number == true) {

            $attributeNames['reference'] = $settings->reference_field_label;
        }

        if ($settings->requires_uploading_attachment == true) {

            $attributeNames['attachment'] = $settings->attachment_field_label;
        }

        return $attributeNames;
    }
}
