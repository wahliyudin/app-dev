<?php

namespace App\Domain\Gateway\Dto;

use Spatie\LaravelData\Data;

class DepartmentDto extends Data
{
    public function __construct(
        public readonly ?string $dept_id = null,
        public readonly ?string $dept_code = null,
        public readonly ?string $budget_dept_code = null,
        public readonly ?string $department_name = null,
        public readonly ?string $dept_head = null,
        public readonly ?string $division_id = null,
        public readonly ?string $project_id = null,
    ) {}
}
