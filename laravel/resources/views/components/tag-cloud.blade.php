<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Popular Tags</h3>
    <div class="flex flex-wrap gap-2">
        @foreach($tags as $tagData)
            <a href="{{ route('posts.index', ['tag' => $tagData['tag']->slug]) }}" 
               class="inline-block px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors"
               style="font-size: {{ $tagData['fontSize'] }}">
                {{ $tagData['tag']->name }}
                <span class="text-xs text-indigo-500">({{ $tagData['tag']->posts_count }})</span>
            </a>
        @endforeach
    </div>
</div>