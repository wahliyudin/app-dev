<?php

namespace App\Domain\Gateway\Services;

use App\Domain\Gateway\Contracts\BaseService;

class UserService extends BaseService
{
    const PATTERN = '/user';

    public function url()
    {
        return $this->baseUrl() . self::PATTERN;
    }

    public function currentUser($token = null)
    {
        return $this->get($this->url(), token: $token)->json();
    }
}
