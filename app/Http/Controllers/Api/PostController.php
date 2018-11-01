<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Talk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $this->middleware('auth:api');
    }

    public function sendRequest(Request $request)
    {
        $post = new Post($request->all());

        $this->authorize('update', $post->talk);

        $post->save();

        broadcast(new PrivatePostSent($post))->toOthers();

        return $post;
    }

    public function setAccept(Request $request)
    {
        dd($request->talk_id);
        $request->merge([
            'comment' => 0,
            'user_id' => auth()->id()
        ]);

        $post = $this->sendRequest($request);

        return redirect()->route('talks.show', $post->id)->with(['post' => $post]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->merge([
            'comment' => 0,
            'user_id' => auth()->id()
        ]);

        return response(['post' => $this->sendRequest($request)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
