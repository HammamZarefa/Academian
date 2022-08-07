<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParaphraseRequest extends FormRequest
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
            'text' => 'required|min:10',
            'language' => 'required',
            'strength' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'A text is required',
            'text.min' => 'A text is minimum 50 character',

            'language.required' => 'A language is required',

            'strength.required' => 'A strength value is required',
        ];
    }
}
