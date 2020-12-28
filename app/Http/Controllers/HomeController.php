<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show objects dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function objects()
    {
        return view('objects');
    }

    /**
     * Show commands dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function commands()
    {
        return view('commands');
    }

    /**
     * Show invites dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invites()
    {
        return view('invites');
    }
}
