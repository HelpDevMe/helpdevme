<?php

namespace App\Http\Controllers;

use App\Post;
use App\Talk;
use App\Question;
use Illuminate\Http\Request;
use App\Events\PrivatePostSent;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'user_id' => $request->user_id,
            'receiver_id' => $request->receiver_id,
            'question_id' => $request->question_id
        ]);

        $this->authorize('store-comment', $talk);

        Post::updateOrCreate(
            [
                'talk_id' => $talk->id,
                'user_id' => auth()->id()
            ],
            [
                'body'=> $request->body,
                'budget'=> $request->budget
            ]
        );

        return back()->with('success', 'Mensagem enviada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        
        return view('posts.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * Update the status filed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('accept', $post);

        $question = $post->talk->question;
        $question->status = Question::WARRANTY;
        $question->update();

        $post->status = Post::status['accept'];
        $post->update();

        $talk = $post->talk;
        $talk->status = Talk::status['active'];
        $talk->update();

        $alert = new Post;
        $alert->talk_id = $post->talk->id;
        $alert->user_id = auth()->id();
        $alert->body = 'Proposta Aceita';
        $alert->type = Post::types['alert'];
        $alert->status = Post::status['accept'];
        $alert->save();

        broadcast(new PrivatePostSent($alert));

        return back()->with('success', 'Proposta aceita! Realize o deposito de garantia.');
    }

    public function refused(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('refused', $post);

        $question = $post->talk->question;
        $question->status = Question::ANALYZING;
        $question->update();

        $post->status = Post::status['refused'];
        $post->update();
        
        $talk = $post->talk;
        $talk->status = Talk::status['inactive'];
        $talk->update();

        $alert = new Post;
        $alert->talk_id = $post->talk->id;
        $alert->user_id = auth()->id();
        $alert->body = 'Proposta Recusada';
        $alert->type = Post::types['alert'];
        $alert->status = Post::status['refused'];
        $alert->save();

        broadcast(new PrivatePostSent($alert));

        return back()->with('success', 'Proposta recusada!');
    }
}
