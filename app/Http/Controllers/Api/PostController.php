<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Post;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\PrivateMessageSent;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchMessages()
    {
        return Post::with('user')->get();
    }

    public function privateMessages(User $user)
    {
        $privateCommunication = Post::with('user')
            ->where(['user_id' => auth()->id(), 'receiver_id' => $user->id])
            ->orWhere(function ($query) use ($user) {
                $query->where(['user_id' => $user->id, 'receiver_id' => auth()->id()]);
            })
            ->get();

        return $privateCommunication;
    }

    public function sendPrivateMessage(Request $request, User $user)
    {
        $input = $request->all();
        $input['receiver_id'] = $user->id;
        $message = auth()->user()->messages()->create($input);

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();

        return response(['status' => 'Message private sent successfully', 'message' => $message]);

    }
}
