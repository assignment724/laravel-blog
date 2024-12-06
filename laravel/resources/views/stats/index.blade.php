<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Posts per Month</h3>
                    <canvas id="postsPerMonthChart"></canvas>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Posts per User</h3>
                    <canvas id="postsPerUserChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const monthlyCtx = document.getElementById('postsPerMonthChart');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($postsPerMonth->pluck('month')) !!},
                datasets: [{
                    label: 'Number of Posts',
                    data: {!! json_encode($postsPerMonth->pluck('count')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const userCtx = document.getElementById('postsPerUserChart');
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($postsPerUser->pluck('name')) !!},
                datasets: [{
                    label: 'Number of Posts',
                    data: {!! json_encode($postsPerUser->pluck('count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>