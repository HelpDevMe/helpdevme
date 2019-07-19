<?php

namespace App\Events;

use App\Post;
use App\Question;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivatePostSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $question;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post, Question $question = null)
    {
        $this->post = $post;
        $this->question = $question;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('privatechat.' . $this->post->talk->user_id . '.' . $this->post->talk->receiver_id . '.private');
    }
}
