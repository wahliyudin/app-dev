<?php

namespace App\Domain\API\Employee;

use App\Domain\API\Employee\Contracts\EmployeeService;

class UserService extends EmployeeService
{
    const PREFIX = '/user';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function first($token)
    {
        return $this->get($this->url(), token: $token)->json();
    }
}
