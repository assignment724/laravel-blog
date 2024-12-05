<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Writer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 text-sm font-medium">Total Posts</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $stats['total_posts'] }}
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('posts.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Create new post →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Recent Posts</h3>
                    <div class="space-y-4">
                        @forelse($stats['recent_posts'] as $post)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <a href="{{ route('posts.show', $post) }}" class="text-base font-medium text-indigo-600 hover:text-indigo-900">
                                            {{ $post->title }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $post->created_at->format('F j, Y') }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('posts.edit', $post) }}" class="text-sm text-gray-500 hover:text-gray-700">Edit</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No posts yet. Why not create one?</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>