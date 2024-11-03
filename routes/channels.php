<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('bot-connections', function ($user) {
    return true;
});
