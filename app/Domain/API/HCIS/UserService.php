<?php

namespace App\Domain\API\HCIS;

use App\Domain\API\HCIS\Contracts\HCISService;

class UserService extends HCISService
{
    const PREFIX = '/authuser';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function first($token)
    {
        return $this->get($this->url(), token: $token)->json();
    }
}
