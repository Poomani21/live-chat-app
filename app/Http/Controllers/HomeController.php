<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usersWithSupportAgentRole = User::where('role', 'support_agent')->first();
        $customers = Message::with('user')->where('user_id','<>',$usersWithSupportAgentRole->id)->get();
        return view('home',compact('customers'));
    }
}
