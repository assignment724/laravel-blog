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
                    <div class="mb-4 text-gray-600">
                        By {{ $post->user->name }} | {{ $post->created_at->format('F j, Y') }}
                    </div>
                    <div class="prose max-w-none">
                        {{ $post->content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>