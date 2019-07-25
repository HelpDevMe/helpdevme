<?php

namespace App\Http\Controllers;

use App\Finance;
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

    public function index()
    {
        $finances = Finance::where('confirmed', 1)
            ->where('user_id', auth()->id())
            ->get();

        return view('finances.index', compact('finances'));
    }

    public function fund()
    {
        return view('finances.fund');
    }
}
