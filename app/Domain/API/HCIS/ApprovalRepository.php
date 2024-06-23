<?php

namespace App\Domain\API\HCIS;

use App\Domain\API\HCIS\Contracts\HCISService;

class ApprovalRepository extends HCISService
{
    const PREFIX = '/workflows';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function getBySubmitted(array $data)
    {
        return $this->post($this->url(), $data)->json();
    }
}
