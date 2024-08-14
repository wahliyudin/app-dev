<?php

namespace App\Domain\Gateway\Services;

use App\Domain\Gateway\Contracts\BaseService;
use Illuminate\Support\Arr;

class EmployeeService extends BaseService
{
    const PATTERN = '/employees';

    public function url()
    {
        return $this->baseUrl() . self::PATTERN;
    }

    public function all()
    {
        $url = $this->extendUrl('all');
        return $this->get($url);
    }

    public function first()
    {
        $response = $this->all();
        return Arr::first($response);
    }

    public function dataForSelect($term, $withNik = true)
    {
        $url = $this->extendUrl('data/for-select');
        return $this->get($url, [
            'term' => $term,
            'with_nik' => $withNik,
        ]);
    }
}
