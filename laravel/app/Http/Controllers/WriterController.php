<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WriterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:writer');
    }

    public function dashboard()
    {
        $userId = auth()->id();
        $now = Carbon::now();
        $sixMonthsAgo = $now->copy()->subMonths(6)->startOfMonth();
        
        $stats = [
            'total_posts' => Post::where('user_id', $userId)->count(),
            'total_views' => Post::where('user_id', $userId)->sum('views'),
            'total_comments' => Post::where('user_id', $userId)->sum('comments_count'),
            'total_likes' => Post::where('user_id', $userId)->sum('likes_count'),
            'recent_posts' => Post::where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get(),
        ];

        $stats['engagement_rate'] = $stats['total_views'] > 0 
            ? round((($stats['total_comments'] + $stats['total_likes']) / $stats['total_views']) * 100, 1)
            : 0;

        $postsLastMonth = Post::where('user_id', $userId)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->count();
        
        $postsThisMonth = Post::where('user_id', $userId)
            ->whereMonth('created_at', $now->month)
            ->count();

        $stats['posts_growth'] = $postsLastMonth > 0 
            ? round((($postsThisMonth - $postsLastMonth) / $postsLastMonth) * 100, 1)
            : ($postsThisMonth > 0 ? 100 : 0);

        $monthlyData = Post::where('user_id', $userId)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b") as month'),
                DB::raw('SUM(views) as views'),
                DB::raw('SUM(comments_count) as comments'),
                DB::raw('SUM(likes_count) as likes'),
                DB::raw('MONTH(created_at) as month_num')
            )
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();

        $months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('M');
        });

        $chartData = $months->map(function($month) use ($monthlyData) {
            $found = $monthlyData->firstWhere('month', $month);
            return [
                'month' => $month,
                'views' => $found ? $found->views : 0,
                'comments' => $found ? $found->comments : 0,
                'likes' => $found ? $found->likes : 0
            ];
        });

        return view('writer.dashboard', compact('stats', 'chartData'));
    }
}