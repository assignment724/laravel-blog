<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:writer');
    }

    public function dashboard()
    {
        $stats = [
            'total_posts' => Post::where('user_id', auth()->id())->count(),
            'recent_posts' => Post::where('user_id', auth()->id())
                                ->latest()
                                ->take(5)
                                ->get(),
        ];

        return view('writer.dashboard', compact('stats'));
    }
}