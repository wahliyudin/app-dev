<?php

namespace App\Domain\API\HCIS\Contracts;

use App\Domain\API\APIInterface;
use Illuminate\Support\Facades\Http;

abstract class HCISService implements APIInterface
{
    public function baseUrl()
    {
        $url = config('urls.hcis');
        if (in_array(str($url)->substr(strlen($url) - 1), ['/'])) {
            return $url . 'api';
        }
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
