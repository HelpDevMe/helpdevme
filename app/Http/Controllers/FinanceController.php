<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Question;
use App\Post;
use App\User;

class FinanceController extends Controller
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

    public function index()
    {
        $finances = Finance::where('confirmed', 1)
            ->where('user_id', auth()->id())
            ->get();

        return view('finances.index', compact('finances'));
    }

    public function transfer(Question $question)
    {
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

        return redirect()->route('finances.index');
    }
}
