<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Question;
use App\Post;
use Illuminate\Http\Request;

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

    protected function finances()
    {
        return Finance::where('confirmed', 1)
            ->where(function ($query) {
                return $query->where('user_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->get();
    }

    protected function balance()
    {
        return $this->finances()->reduce(function ($balance, $finance) {
            if ($finance->type == Finance::types['fund'] || $finance->type == Finance::types['received']) {
                return $balance + $finance->budget;
            }
        });
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finance $finance)
    {
        //
    }

    public function transfer(Question $question)
    {
        $post = $question->posts->where('status', Post::status['payment'])->first();

        $finance = new Finance;
        $finance->user_id = auth()->id();
        $finance->receiver_id = $post->user->id;
        $finance->budget = $post->budget;
        $finance->post_id = $post->id;
        $finance->type = Finance::types['received'];
        $finance->save();

        return redirect()->route('finances.index');
    }
}
