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

/**
 * Presence
 */
Broadcast::channel('privatechat.{talk_id}.join', function ($user) {
    return auth()->check() ? $user : false;
});

/**
 * Private
 */
Broadcast::channel('comments.{question_id}.private', function () {
    return true;
});

Broadcast::channel('privatechat.{talk_id}.private', function () {
    return auth()->check();
});

Broadcast::channel('newquestions', function () {
    return auth()->check();
});
