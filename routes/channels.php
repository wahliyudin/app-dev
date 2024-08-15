<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('example-channel', function () {
    return true;
});
