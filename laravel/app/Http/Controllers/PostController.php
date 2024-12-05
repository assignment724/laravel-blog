<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags']);
    
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }
    
        $posts = $query->latest()->paginate(10);
        
        $currentTag = null;
        if ($request->has('tag')) {
            $currentTag = Tag::where('slug', $request->tag)->first();
        }
    
        return view('posts.index', compact('posts', 'currentTag'));
    }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|max:255',
    //         'content' => 'required',
    //         'category_id' => 'required|exists:categories,id',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    //     ]);

    //     $validated['user_id'] = auth()->id();
        
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('posts', 'public');
    //         $validated['image_path'] = $imagePath;
    //     }
        
    //     $post = Post::create($validated);
        
    //     return redirect()->route('posts.show', $post)
    //                     ->with('success', 'Post created successfully.');
    // }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (auth()->user()->role === 'writer' && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // public function update(Request $request, Post $post)
    // {
    //     if (auth()->user()->role === 'writer' && $post->user_id !== auth()->id()) {
    //         abort(403);
    //     }

    //     $validated = $request->validate([
    //         'title' => 'required|max:255',
    //         'content' => 'required',
    //         'category_id' => 'required|exists:categories,id',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    //     ]);

    //     if ($request->hasFile('image')) {
    //         if ($post->image_path) {
    //             Storage::disk('public')->delete($post->image_path);
    //         }
    //         $imagePath = $request->file('image')->store('posts', 'public');
    //         $validated['image_path'] = $imagePath;
    //     }

    //     $post->update($validated);

    //     return redirect()->route('posts.show', $post)
    //                     ->with('success', 'Post updated successfully.');
    // }

    public function destroy(Post $post)
    {
        if (auth()->user()->role !== 'admin' && $post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully.');
    }



    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = auth()->id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image_path'] = $imagePath;
        }
        
        $post = Post::create($validated);
        
        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post created successfully.');
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->role === 'writer' && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image_path'] = $imagePath;
        }

        $post->update($validated);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post updated successfully.');
    }
}