<?php

namespace App\Http\Controllers;

use App\Question;
use App\Post;
use App\Finance;
use App\User;

use App\Events\PrivatePostSent;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::where('status', Question::status['analyzing'])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('questions.index', compact('questions'));
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
            'title' => 'required|unique:questions',
            'body' => 'required'
        ]);

        $request->merge([
            'slug' => str_slug($request->title),
            'user_id' => auth()->id()
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')
            ->with('success', 'Pergunta criada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function finalize(Question $question)
    {
        $who = auth()->id() == $question->user_id ? 'user_ended' : 'freelancer_ended';
        $question[$who] = 1;
        $question->save();

        // Ambas as partes finalizaram
        if ($question->user_ended == 1 && $question->freelancer_ended == 1) {

            // Atualizar status da pergunta
            $question->status = Question::status['finalized'];
            $question->update();

            $post = $question->posts
                ->where('type', Post::types['comment'])
                ->where('status', Post::status['payment'])
                ->first();

            /**
             * Histórico de transação do recebedor
             */
            $financeReceiver = new Finance;
            $financeReceiver->user_id = $post->talk->user_id;
            $financeReceiver->receiver_id = auth()->id();
            $financeReceiver->type = Finance::types['received'];
            $financeReceiver->budget = number_format($post->budget, 2, '.', '');
            $financeReceiver->post_id = $post->id;
            $financeReceiver->confirmed = 1;
            $financeReceiver->save();

            $receiver = User::find($post->talk->user_id);

            $receiver->amount += $post->budget;
            $receiver->update();

            // Notificar em tempo real
            $alert = new Post;
            $alert->talk_id = $post->talk->id;
            $alert->user_id = auth()->id();
            $alert->body = 'Finalizado';
            $alert->type = Post::types['alert'];
            $alert->status = Post::status['finalized'];
            $alert->save();

            broadcast(new PrivatePostSent($alert));

            return redirect()->route('talks.show', $post->talk)->with('success', 'Questão Finalizada!');
        }

        return back();
    }
}
