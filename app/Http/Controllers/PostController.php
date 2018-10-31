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

        $post = new Post([
            'talk_id' => $talk->id,
            'user_id' => auth()->id(),
            'body'=> $request->body,
            'budget'=> $request->budget
        ]);

        $post->save();

        return redirect()->route('home')->with('success', 'Mensagem enviada!');
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
     * Update the status_id filed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $question = $post->talk->question;
        $question->status_id = Question::WARRANTY;
        $question->update();

        broadcast(new PrivatePostSent($post));

        return redirect()->action(
            'Api\PostController@sendRequest', [
                'talk_id' => $post->talk->id,
                'body' => 'Proposta aceita'
            ]
        );
    }
}
