<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $postsPerMonth = Post::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $postsPerUser = Post::select('users.name', DB::raw('COUNT(*) as count'))
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('count', 'desc')
            ->get();

        return view('stats.index', compact('postsPerMonth', 'postsPerUser'));
    }
}