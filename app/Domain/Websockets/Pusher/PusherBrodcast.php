<?php

namespace App\Domain\Websockets\Pusher;

use App\Domain\Websockets\Helper\Helper;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Pusher\Pusher;

class PusherBrodcast
{
    public function __construct(
        protected Helper $helper
    ) {}

    public function init()
    {
        $pusher = $this->pusher();
        return new PusherBroadcaster($pusher);
    }

    public function pusher()
    {
        return new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options', []),
            $this->helper->client()
        );
    }

    public function send(string $channel, string $event, array $payload)
    {
        return $this->init()->broadcast(
            [$channel],
            $event,
            $payload
        );
    }
}
