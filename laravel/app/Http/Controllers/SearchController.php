<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('search.index', [
            'users' => $users,
            'posts' => null
        ]);
    }

    public function search(Request $request)
    {
        $query = Post::query();
        $users = User::all();

        // Search by title/content
        if ($request->filled('search_text')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search_text . '%')
                  ->orWhere('content', 'like', '%' . $request->search_text . '%');
            });
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereDate('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->whereDate('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        return view('search.index', [
            'users' => $users,
            'posts' => $query->paginate(10)
        ]);
    }
}