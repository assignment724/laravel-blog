<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function dashboard()
    {
        $monthlyPosts = Post::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->take(6)
            ->get()
            ->reverse();

        $dailyUsers = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'recent_posts' => Post::with('user')->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
            'users_by_role' => [
                'admin' => User::where('role', 'admin')->count(),
                'writer' => User::where('role', 'writer')->count(),
                'user' => User::where('role', 'user')->count(),
            ],
            'monthly_posts_labels' => $monthlyPosts->pluck('month')->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M Y');
            }),
            'monthly_posts_data' => $monthlyPosts->pluck('count'),
            'daily_users_labels' => $dailyUsers->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            }),
            'daily_users_data' => $dailyUsers->pluck('count'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,writer,user'
        ]);

        $user->update($validated);

        return back()->with('success', 'User role updated successfully');
    }
}