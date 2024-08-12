<?php

namespace App\Domain\Gateway\Dto;

use Spatie\LaravelData\Data;

class DivisiDto extends Data
{
    public function __construct(
        public readonly ?string $division_id = null,
        public readonly ?string $division_name = null,
        public readonly ?string $division_head = null,
    ) {}
}
