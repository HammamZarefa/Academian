<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PriceType;

class StoreServicesRequest extends FormRequest
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

        switch ($this->method()) {
            case 'PATCH':
                $nameRule = 'required|unique:services,id,' . $this->id;
                break;
            default:
                $nameRule = "required|unique:services";
                break;
        }

        $rules = [
            'name' => $nameRule,
            'price_type_id' => 'required',
        ];

        if (in_array($this->price_type_id, [PriceType::PerPage, PriceType::PerWord])) {
            $rules['minimum_order_quantity'] = 'required|numeric|min:1';            
        }

        if ($this->price_type_id == PriceType::PerPage) {
            $rules['single_spacing_price'] = 'required|numeric|min:1';
            $rules['double_spacing_price'] = 'required|numeric|min:1';
        } else {
            $rules['price'] = 'required|regex:/^\d+(\.\d{1,2})?$/';
        }

        return $rules;
    }
}
