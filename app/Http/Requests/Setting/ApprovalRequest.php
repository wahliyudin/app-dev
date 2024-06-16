<?php

namespace App\Http\Requests\Setting;

use App\Enums\Settings\Approval;
use App\Enums\Workflows\Module;
use Illuminate\Foundation\Http\FormRequest;

class ApprovalRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $modules = collect(Module::cases())->pluck('value');
        $rules = [];
        for ($i = 0; $i < count($modules); $i++) {
            for ($j = 0; $j < count(request()->get($modules[$i]) ?? []); $j++) {
                if (request()->get($modules[$i]) !== null) {
                    $rules["$modules[$i].$j" . '.title'] = 'required';
                    $rules["$modules[$i].$j" . '.approval'] = 'required';
                }
                if (Approval::byValue(request()->get($modules[$i])[$j]['approval'] ?? '') === Approval::OTHER) {
                    $rules["$modules[$i].$j" . '.nik'] = 'required';
                }
            }
        }
        return $rules;
    }
}
