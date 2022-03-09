<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Service;
use App\Enums\PriceType;
use App\Enums\SpacingType;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => Purifier::clean($this->title),
            'instruction' => Purifier::clean($this->instruction)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
            'instruction' => 'required',
            'service_id' => 'required',
            'work_level_id' => 'required',
            'urgency_id' => 'required',
            'dead_line' => 'required',
            'quantity' => 'required',
            'added_services' => 'nullable|array',
            'files_data' => 'nullable|array',
        ];

        if (Service::find($this->service_id)->price_type_id  == PriceType::PerPage) {
            $rules['spacing_type'] = [
                'required',
                Rule::in([SpacingType::DoubleLine, SpacingType::SingleLine]),
            ];
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false
        ]));
    }
}
