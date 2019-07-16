<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Question;
use App\Post;

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
        $post = $question->posts->where('status', Post::status['payment'])->first();

        $finance = new Finance;
        $finance->user_id = auth()->id();
        $finance->budget = $post->budget;
        $finance->post_id = $post->id;
        $finance->type = Finance::types['received'];
        $finance->save();

        return redirect()->route('finances.index');
    }
}
