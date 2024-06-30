<?php

namespace App\Http\Requests\Applications\Setting;

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
            'display_name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => 'Display name is required',
            'description.required' => 'Description is required',
            'due_date.required' => 'Due date is required',
            'status.required' => 'Status is required',
        ];
    }
}
