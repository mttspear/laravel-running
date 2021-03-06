<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel("App.Models.User.{id}", function ($user, $id) {
    return true;
});

Broadcast::channel("game.{id}", function ($user, $id) {
    Log::info("userId:" . $user->id . " id:" . $id);
    return $user->id === (int) $id;
});
