<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SummarizeRequest extends FormRequest
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
            'text' => 'required|min:50',
            'language' => 'required',
            'output_sentences' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'A text is required',
            'text.min' => 'A text is minimum 50 character',

            'language.required' => 'A language is required',

            'output_sentences.required' => 'A output sentences is required',
        ];
    }
}
