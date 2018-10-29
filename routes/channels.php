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

Broadcast::channel('privatechat', function ($user) {
    return auth()->check() ? $user : null;
});

Broadcast::channel('privatechat.{question_id}', function ($user, $question_id) {
    return auth()->check();
});
