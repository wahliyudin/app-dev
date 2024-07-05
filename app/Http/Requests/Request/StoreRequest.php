<?php

namespace App\Http\Requests\Request;

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
        $rules = [
            'department_id' => ['required'],
            'nik_requestor' => ['required'],
            'code' => ['required'],
            'job_title' => ['required'],
            'department' => ['required'],
            'pic_user' => ['required'],
            'estimated_project' => ['required'],
            'email' => ['required'],
            'date' => ['required'],
            'type_request' => ['required'],
            'type_budget' => ['required'],
            'description' => ['required'],
            'attachments' => ['required', 'array'],
        ];
        if (in_array($this->type_request, ['new_application', 'replace_an_existing_application'])) {
            $rules['application_name'] = ['required'];
        }
        if (in_array($this->type_request, ['new_automate_application', 'enhancement_to_existing_application'])) {
            $rules['application_id'] = ['required'];
        }
        if ($this->type_request == 'new_automate_application') {
            $rules['feature_name'] = ['required'];
        }
        if ($this->type_request == 'enhancement_to_existing_application') {
            $rules['feature_id'] = ['required'];
        }
        return $rules;
    }
}
