<?php

namespace App\Data\Settings;

use App\Enums\Workflows\Module;
use App\Http\Requests\Setting\ApprovalRequest;

class ApprovalDto
{
    public function __construct(
        public readonly ?Module $module,
        public readonly ?array $keys,
        public readonly ?array $data,
    ) {
    }

    public static function fromRequest(ApprovalRequest $request): self
    {
        $module = Module::byValue($request->get('module'));
        return new self(
            $module,
            collect($request->get($module->value))->pluck('key')->toArray(),
            $request->get($module->value),
        );
    }
}
