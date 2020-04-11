<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $model;
    public function __construct(User $model)
    {
        $this->middleware('auth');
        $this->model = $model;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->checkRole(1))
            return redirect(route('admin.dashboard.index'));
        if(auth()->user()->checkRole(2))
            return redirect(route('group.index'));
        return view('home',['tests' => $this->model->getUserTests(Auth::id())]);
    }
    public function settings()
    {
        return view('user_settings');
    }
}
