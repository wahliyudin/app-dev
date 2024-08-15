<?php

namespace App\Domain\Websockets\Helper;

use GuzzleHttp\Client;

class Helper
{
    public function client()
    {
        $config = [];
        if (config('broadcasting.connections.pusher.options.useTLS')) {
            $config['verify'] = config('broadcasting.connections.pusher.client_options.verify');
        }
        return new Client($config);
    }
}
