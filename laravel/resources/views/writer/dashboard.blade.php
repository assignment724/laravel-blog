<x-app-layout>
    <x-slot name="header">
    <div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
            {{ __('Writer Dashboard') }}
        </h2>
    </div>
</div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Posts Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="px-6 py-5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium text-white/90">Total Posts</div>
                            <svg class="w-6 h-6 text-white/90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-2xl font-bold text-white">{{ $stats['total_posts'] }}</div>
                        <div class="mt-3 flex items-center text-sm text-white/90">
                            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>{{ number_format(abs($stats['posts_growth']), 1) }}% from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Total Views Card -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="px-6 py-5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium text-white/90">Total Views</div>
                            <svg class="w-6 h-6 text-white/90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-2xl font-bold text-white">{{ number_format($stats['total_views']) }}</div>
                    </div>
                </div>

                <!-- Total Comments Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="px-6 py-5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium text-white/90">Total Comments</div>
                            <svg class="w-6 h-6 text-white/90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-2xl font-bold text-white">{{ number_format($stats['total_comments']) }}</div>
                    </div>
                </div>

                <!-- Engagement Rate Card -->
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="px-6 py-5">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium text-white/90">Engagement Rate</div>
                            <svg class="w-6 h-6 text-white/90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-2xl font-bold text-white">{{ $stats['engagement_rate'] }}%</div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Views Chart -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100 transform transition-all duration-200 hover:shadow-xl">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Views Trend</h3>
                        <canvas id="viewsChart" class="w-full" height="300"></canvas>
                    </div>
                </div>

                <!-- Engagement Chart -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100 transform transition-all duration-200 hover:shadow-xl">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Engagement Metrics</h3>
                        <canvas id="engagementChart" class="w-full" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Your Recent Posts</h3>
                        <a href="{{ route('posts.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            Create New Post
                        </a>
                    </div>
                </div>

                <!-- Posts List -->
                <div class="divide-y divide-gray-200 bg-white">
                    @forelse($stats['recent_posts'] as $post)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('posts.show', $post) }}" 
                                       class="text-lg font-medium text-indigo-600 hover:text-indigo-900 hover:underline">
                                        {{ $post->title }}
                                    </a>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($post->views) }} views
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            {{ $post->comments_count }} comments
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('posts.edit', $post) }}" 
                                   class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-100 transition-colors duration-200">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-gray-500">No posts yet. Why not create one?</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        const viewsCtx = document.getElementById('viewsChart').getContext('2d');
        new Chart(viewsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData->pluck('month')) !!},
                datasets: [{
                    label: 'Total Views',
                    data: {!! json_encode($chartData->pluck('views')) !!},
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Views: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
        new Chart(engagementCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData->pluck('month')) !!},
                datasets: [
                    {
                        label: 'Comments',
                        data: {!! json_encode($chartData->pluck('comments')) !!},
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                    },
                    {
                        label: 'Likes',
                        data: {!! json_encode($chartData->pluck('likes')) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>