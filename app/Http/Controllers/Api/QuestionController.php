<?php

namespace App\Http\Controllers\Api;

use App\Question;
use App\Vote;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\NewQuestionsEvent;

class QuestionController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with(['talks', 'comments'])
            ->get();

        return response(['questions' => $questions]);
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
            'title' => 'required',
            'body' => 'required'
        ]);

        $question = new Question;
        $question->title = $request->title;
        $question->slug = str_slug($request->title);
        $question->body = $request->body;
        $question->user_id = auth()->id();
        $question->tags()->attach($request->tags);

        $question->save();

        $question->load('comments');

        broadcast(new NewQuestionsEvent($question))->toOthers();

        return response(['question' => $question]);
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
        Vote::updateOrCreate(
            [
                'question_id' => $id,
                'user_id' => auth()->id()
            ],
            [
                'vote' => $request->vote
            ]
        );

        $votes = Vote::where('question_id', $id)->where('vote', 1)->count();

        return response(['votes' => $votes]);
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
