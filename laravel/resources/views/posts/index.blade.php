<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog Posts') }}
            </h2>
            @if(auth()->check() && (auth()->user()->role === 'writer' || auth()->user()->role === 'admin'))
                <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create New Post
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($posts as $post)
                        <article class="mb-8">
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4">
                                By {{ $post->user->name }} | {{ $post->created_at->format('F j, Y') }}
                            </p>
                            <div class="prose">
                                {{ Str::limit($post->content, 200) }}
                            </div>
                        </article>
                    @endforeach

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>