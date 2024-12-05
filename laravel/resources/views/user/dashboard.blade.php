<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Blog Posts</h3>
                    <div class="space-y-4">
                        @forelse($recent_posts as $post)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                <div>
                                    <a href="{{ route('posts.show', $post) }}" class="text-base font-medium text-indigo-600 hover:text-indigo-900">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-sm text-gray-500">
                                        By {{ $post->user->name }} | {{ $post->created_at->format('F j, Y') }}
                                    </p>
                                    <p class="mt-2 text-gray-600">
                                        {{ Str::limit($post->content, 150) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No posts available.</p>
                        @endforelse
                        
                        <div class="mt-6">
                            <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                View all posts →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>