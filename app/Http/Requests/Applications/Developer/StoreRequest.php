<?php

namespace App\Http\Requests\Applications\Developer;

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
            'developer_nik' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'developer_nik.required' => 'Developer is required',
        ];
    }
}
