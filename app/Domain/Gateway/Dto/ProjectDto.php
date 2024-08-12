<?php

namespace App\Domain\Gateway\Dto;

use Spatie\LaravelData\Data;

class ProjectDto extends Data
{
    public function __construct(
        public readonly ?string $project_id = null,
        public readonly ?string $project = null,
        public readonly ?string $project_prefix = null,
        public readonly ?string $location = null,
        public readonly ?string $location_prefix = null,
        public readonly ?string $pjo = null,
    ) {}
}
