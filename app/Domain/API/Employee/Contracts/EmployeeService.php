<?php

namespace App\Domain\API\Employee\Contracts;

use App\Domain\API\APIInterface;
use Illuminate\Support\Facades\Http;

abstract class EmployeeService implements APIInterface
{
    public function baseUrl()
    {
        $url = rtrim(config('urls.employee'), '/');
        return $url . '/api';
    }

    public abstract function url();

    public function extendUrl($extend): string
    {
        return $this->url() . "/$extend";
    }

    protected function get($url, $query = null, $token = null)
    {
        $token = $this->token() ?? $token;
        return Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->get($url, $query);
    }

    protected function post($url, $data = [], $token = null)
    {
        $token = $this->token() ?? $token;
        return Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->post($url, $data);
    }

    private function token()
    {
        return authUser()?->loadMissing('oatuhToken')?->oatuhToken?->access_token;
    }
}
