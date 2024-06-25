<?php

namespace App\Http\Requests\Task;

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
            'feature_id' => ['required'],
            'status' => ['required'],
            'content' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'feature_id.required' => 'Feature is required',
            'status.required' => 'Status is required',
            'content.required' => 'Content is required',
        ];
    }
}
