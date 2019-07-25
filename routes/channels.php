<?php

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

Broadcast::channel('privatechat.{user_id}.{receiver_id}.join', function ($user, $user_id, $receiver_id) {
    return auth()->check() && ((int) $user->id === (int) $user_id || $user->id === (int) $receiver_id) ? $user : false;
});

Broadcast::channel('privatechat.{user_id}.{receiver_id}.private', function ($user, $user_id, $receiver_id) {
    return auth()->check() && ((int) $user->id === (int) $user_id || $user->id === (int) $receiver_id);
});

Broadcast::channel('newquestions', function () {
    return auth()->check();
});
