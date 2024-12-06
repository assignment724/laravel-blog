<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WriterController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredPosts = Post::get();
    return view('welcome', compact('featuredPosts'));
})->name('home');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/results', [SearchController::class, 'search'])->name('search.results');
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/test', function() {
    dd([
        'user_role' => auth()->user()->role,
        'route_exists' => route('posts.create'),
        'categories' => Category::all()
    ]);
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'writer') {
            return redirect()->route('writer.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tags', TagController::class)->only(['index', 'store', 'destroy']);

    Route::middleware('check.role:writer,admin')->group(function () {
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    });

    Route::middleware('check.role:writer')->group(function () {
        Route::get('/writer/dashboard', [WriterController::class, 'dashboard'])->name('writer.dashboard');
    });

    Route::middleware('check.role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role.update');
        Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    });
});

require __DIR__.'/auth.php';