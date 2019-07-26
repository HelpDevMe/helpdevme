<?php

namespace App\Http\Controllers\Api;

use App\Talk;
use App\Post;
use App\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\PrivateCommentSent;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $talk = Talk::firstOrCreate([
            'user_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'question_id' => $request->question_id
        ]);

        $this->authorize('store-comment', $talk);

        $post = new Post;
        $post->talk_id = $talk->id;
        $post->user_id = auth()->id();
        $post->body = $request->body;
        $post->type = $request->type;
        $post->budget = $request->budget;

        $this->authorize('message', $post);

        $post->save();

        broadcast(new PrivateCommentSent($post))->toOthers();

        return response(['post' => $post]);
    }

    public function byQuestion($id)
    {
        $question = Question::findOrFail($id);

        return response(['comments' => $question->comments()]);
    }
}
