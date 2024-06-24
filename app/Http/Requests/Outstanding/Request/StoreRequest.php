<?php

namespace App\Http\Requests\Outstanding\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'developers' => ['required', 'array', 'min:1'],
            'features' => ['required', 'array', 'min:1'],
            'features.*.name' => ['required', 'string'],
            'features.*.description' => ['nullable', 'string'],
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'features.*.name.required' => 'Line ' . ($this->get('features') ? array_search(null, array_column($this->get('features'), 'name')) + 1 : '') . ', name is required',
        ];
    }
}
