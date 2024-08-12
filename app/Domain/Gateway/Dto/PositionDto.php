<?php

namespace App\Domain\Gateway\Dto;

use Spatie\LaravelData\Data;

class PositionDto extends Data
{
    public function __construct(
        public readonly ?string $position_id = null,
        public readonly ?string $position_name = null,
        public readonly ?string $project_id = null,
        public readonly ?string $division_id = null,
        public readonly ?string $dept_id = null,
        public readonly ?string $jabatan_atasan_langsung = null,
        public readonly ?string $jabatan_atasan_tidak_langsung = null,
        public readonly ?DivisiDto $divisi = null,
        public readonly ?ProjectDto $project = null,
        public readonly ?DepartmentDto $department = null,
    ) {}
}
