<?php

namespace App\Domain\Gateway\Contracts;

use App\Domain\Gateway\Builders\QueryParam;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

abstract class BaseService
{
    use QueryParam;

    protected $token = null;

    public function baseUrl()
    {
        $url = rtrim(config('urls.gateway'), '/');
        return $url . '/api';
    }

    public abstract function url();

    public function extendUrl($extend): string
    {
        return $this->url() . "/$extend";
    }

    public function query()
    {
        return $this->query;
    }

    protected function get($url, $query = null, $token = null)
    {
        $this->setToken($token ?? $this->token());
        if ($query) $this->addQuery($query);
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $this->token",
        ])
            ->get($url, $this->buildQuery());
        if ($response->failed()) {
            throw new \Exception($response->json('message') ?? 'Something went wrong', $response->status());
        }
        return Arr::get($response->json(), 'data', []);
    }

    protected function post($url, $data = [], $token = null)
    {
        $this->setToken($token ?? $this->token());
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $this->token",
        ])->post($url, $data);
        if ($response->failed()) {
            throw new \Exception($response->json('message') ?? 'Something went wrong', $response->status());
        }
        return Arr::get($response->json(), 'data', []);
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    private function token()
    {
        return authUser()?->loadMissing('oauthToken')?->oauthToken?->access_token;
    }
}
