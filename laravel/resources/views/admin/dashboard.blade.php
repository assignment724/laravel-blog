<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 text-sm font-medium">Total Users</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $stats['total_users'] }}
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-gray-500">Admins: {{ $stats['users_by_role']['admin'] }}</span>
                            <span class="text-sm text-gray-500 ml-2">Writers: {{ $stats['users_by_role']['writer'] }}</span>
                            <span class="text-sm text-gray-500 ml-2">Users: {{ $stats['users_by_role']['user'] }}</span>
                        </div>
                        <div class="mt-4 relative" style="height: 250px;">
                            <canvas id="userRolesChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 text-sm font-medium">Total Posts</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $stats['total_posts'] }}
                        </div>
                        <div class="mt-4 relative" style="height: 250px;">
                            <canvas id="postsChart"></canvas>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all posts →</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 text-sm font-medium">User Activity</div>
                        <div class="mt-4 relative" style="height: 250px;">
                            <canvas id="userActivityChart"></canvas>
                        </div>
                        <div class="mt-2 space-y-2">
                            <a href="{{ route('admin.users') }}" class="block text-sm text-indigo-600 hover:text-indigo-900">Manage Users →</a>
                            <a href="{{ route('posts.create') }}" class="block text-sm text-indigo-600 hover:text-indigo-900">Create New Post →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Content Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Posts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Posts</h3>
                        <div class="space-y-4">
                            @foreach($stats['recent_posts'] as $post)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('posts.show', $post) }}" class="text-base font-medium text-indigo-600 hover:text-indigo-900">
                                                {{ $post->title }}
                                            </a>
                                            <p class="text-sm text-gray-500">by {{ $post->user->name }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('posts.edit', $post) }}" class="text-sm text-gray-500 hover:text-gray-700">Edit</a>
                                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Users</h3>
                        <div class="space-y-4">
                            @foreach($stats['recent_users'] as $user)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-base font-medium text-gray-900">{{ $user->name }}</span>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                                   ($user->role === 'writer' ? 'bg-green-100 text-green-800' : 
                                                    'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Shared chart options and styling
        Chart.defaults.font.family = '"Inter", sans-serif';
        Chart.defaults.color = '#6B7280';
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(17, 24, 39, 0.8)';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
        Chart.defaults.plugins.tooltip.titleColor = '#FFFFFF';
        Chart.defaults.plugins.tooltip.bodyColor = '#FFFFFF';
        Chart.defaults.plugins.tooltip.borderColor = 'rgba(255, 255, 255, 0.1)';
        Chart.defaults.plugins.tooltip.borderWidth = 1;

        // User Roles Chart - Enhanced Doughnut
        const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
        new Chart(userRolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Admin', 'Writer', 'User'],
                datasets: [{
                    data: [
                        {{ $stats['users_by_role']['admin'] }},
                        {{ $stats['users_by_role']['writer'] }},
                        {{ $stats['users_by_role']['user'] }}
                    ],
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',  // Red
                        'rgba(34, 197, 94, 0.8)',  // Green
                        'rgba(59, 130, 246, 0.8)'  // Blue
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Posts Chart - Enhanced Line Chart
        const postsCtx = document.getElementById('postsChart').getContext('2d');
        const postsGradient = postsCtx.createLinearGradient(0, 0, 0, 250);
        postsGradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        postsGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(postsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['monthly_posts_labels']) !!},
                datasets: [{
                    label: 'Posts',
                    data: {!! json_encode($stats['monthly_posts_data']) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: postsGradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: 'rgb(59, 130, 246)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(107, 114, 128, 0.1)'
                        },
                        ticks: {
                            padding: 10,
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // User Activity Chart - Enhanced Bar Chart
        const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
        new Chart(userActivityCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stats['daily_users_labels']) !!},
                datasets: [{
                    label: 'Active Users',
                    data: {!! json_encode($stats['daily_users_data']) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                    hoverBackgroundColor: 'rgb(59, 130, 246)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(107, 114, 128, 0.1)'
                        },
                        ticks: {
                            padding: 10,
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    </script>
</x-app-layout>