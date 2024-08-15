<?php

namespace App\Domain\Websockets;


use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Domain\Websockets\Pusher\PusherBrodcast
 *
 * @method static \Illuminate\Broadcasting\BroadcastException send(string $channel, string $event, array $payload)
 *
 * @see \App\Domain\Websockets\Pusher\PusherBrodcast
 */
class PusherBrodcast extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pusher_websocket';
    }
}
