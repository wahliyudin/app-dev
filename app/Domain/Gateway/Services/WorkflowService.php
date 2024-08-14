<?php

namespace App\Domain\Gateway\Services;

use App\Domain\Gateway\Contracts\BaseService;

class WorkflowService extends BaseService
{
    const PATTERN = '/workflows';

    public function url()
    {
        return $this->baseUrl() . self::PATTERN;
    }

    public function getBySubmitted(array $data)
    {
        return $this->post($this->url(), $data);
    }
}
