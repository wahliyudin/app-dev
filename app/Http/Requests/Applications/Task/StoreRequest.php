<?php

namespace App\Http\Requests\Applications\Task;

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
            'due_date' => ['required'],
            'status' => ['required'],
            'content' => ['required'],
            'developers' => ['array', 'min:1', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'feature_id.required' => 'Feature is required',
            'due_date.required' => 'Due date is required',
            'status.required' => 'Status is required',
            'content.required' => 'Content is required',
        ];
    }
}
