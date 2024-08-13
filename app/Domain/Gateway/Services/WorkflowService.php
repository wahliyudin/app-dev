<?php

namespace App\Domain\Gateway\Services;

use App\Domain\Gateway\Contracts\BaseService;
use Illuminate\Support\Arr;

class WorkflowService extends BaseService
{
    const PATTERN = '/workflows';

    public function url()
    {
        return $this->baseUrl() . self::PATTERN;
    }

    public function getBySubmitted(array $data)
    {
        $response = $this->post($this->url(), $data);
        if ($response->failed()) {
            throw new \Exception('Something went wrong');
        }
        return Arr::get($response->json(), 'data', []);
    }
}
