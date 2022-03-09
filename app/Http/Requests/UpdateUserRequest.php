<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return [           
            'first_name'        => 'required|max:255',                     
            'last_name'         => 'required|max:255',      
            'email'             => 'required|email|unique:users,email,'.$this->user->id,
            'bio'               => 'max:500',
            'address'           => 'max:500',
            'preferred_payment_method'          => 'max:255',                     
            'payment_method_details'            => 'max:255',
        ];
    }
}
