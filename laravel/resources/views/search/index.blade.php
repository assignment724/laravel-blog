<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('search.results') }}" class="space-y-6">
                        <!-- Search Text -->
                        <div>
                            <x-label for="search_text" :value="__('Search Text')" />
                            <x-input id="search_text" class="block mt-1 w-full" 
                                type="text" 
                                name="search_text" 
                                value="{{ request('search_text') }}"
                                placeholder="Search in title or content..." />
                        </div>

                        <!-- Author Dropdown -->
                        <div>
                            <x-label for="author" :value="__('Filter by Author')" />
                            <select name="author" id="author" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                <option value="">All Authors</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('author') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range Radio Buttons -->
                        <div>
                            <x-label :value="__('Date Range')" class="mb-2" />
                            <div class="space-y-2">
                                <div>
                                    <input type="radio" id="all_time" name="date_range" value="" 
                                        {{ !request('date_range') ? 'checked' : '' }} class="mr-2">
                                    <label for="all_time">All Time</label>
                                </div>
                                <div>
                                    <input type="radio" id="today" name="date_range" value="today"
                                        {{ request('date_range') === 'today' ? 'checked' : '' }} class="mr-2">
                                    <label for="today">Today</label>
                                </div>
                                <div>
                                    <input type="radio" id="week" name="date_range" value="week"
                                        {{ request('date_range') === 'week' ? 'checked' : '' }} class="mr-2">
                                    <label for="week">This Week</label>
                                </div>
                                <div>
                                    <input type="radio" id="month" name="date_range" value="month"
                                        {{ request('date_range') === 'month' ? 'checked' : '' }} class="mr-2">
                                    <label for="month">This Month</label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-button>
                                {{ __('Search') }}
                            </x-button>
                        </div>
                    </form>

                    @if($posts)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Search Results</h3>
                            @if($posts->count() > 0)
                                @foreach($posts as $post)
                                    <div class="mb-4 p-4 border rounded">
                                        <h4 class="text-xl font-semibold">
                                            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $post->title }}
                                            </a>
                                        </h4>
                                        <p class="text-gray-600">By {{ $post->user->name }} | {{ $post->created_at->format('F j, Y') }}</p>
                                    </div>
                                @endforeach
                                {{ $posts->links() }}
                            @else
                                <p>No posts found matching your criteria.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>