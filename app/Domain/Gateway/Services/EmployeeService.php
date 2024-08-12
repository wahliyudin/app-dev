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
        $response = $this->get($url)->json();
        return Arr::get($response, 'data', []);
    }

    public function first()
    {
        $response = $this->all();
        return Arr::first($response);
    }

    public function dataForSelect($term, $withNik = true)
    {
        $url = $this->extendUrl('data/for-select');
        $response = $this->get($url, [
            'term' => $term,
            'with_nik' => $withNik,
        ]);
        return Arr::get($response, 'data', []);
    }
}
