<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $recent_posts = Post::with('user')
                           ->latest()
                           ->take(5)
                           ->get();

        return view('user.dashboard', compact('recent_posts'));
    }
}