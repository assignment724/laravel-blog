<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
            @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                <div class="flex space-x-4">
                    <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($post->image_path)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="max-w-full h-auto">
                </div>
                @endif
                <div class="mb-4 text-gray-600">
                        By {{ $post->user->name }} | {{ $post->created_at->format('F j, Y') }}
                    </div>
                    <div class="prose max-w-none">
                        {{ $post->content }}
                    </div>
                    @if($post->tags->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
   
</x-app-layout>