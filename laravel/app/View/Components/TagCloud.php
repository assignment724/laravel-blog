<?php

namespace App\View\Components;

use App\Models\Tag;
use Illuminate\View\Component;

class TagCloud extends Component
{
    public function render()
    {
        $tags = Tag::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(20)
            ->get()
            ->map(function ($tag) {
                $fontSize = 0.875 + ($tag->posts_count * 0.1);
                $fontSize = min($fontSize, 1.5);
                return [
                    'tag' => $tag,
                    'fontSize' => $fontSize . 'rem'
                ];
            });

        return view('components.tag-cloud', compact('tags'));
    }
}