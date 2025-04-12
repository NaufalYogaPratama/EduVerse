<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-800">
                    
                    <!-- Navbar -->
                    <nav class="flex items-center justify-between bg-amber-300 p-4 rounded-lg mb-6 shadow-md">
                        <div class="flex items-center">
                            <a class="text-lg font-semibold tracking-tight text-gray-800" href="#">EduVerse Statistics</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            <form class="flex items-center" method="GET" action="{{ route('dashboard') }}">
                                <input class="rounded-l-md border border-gray-300 px-3 py-1 bg-white text-gray-800 placeholder-gray-500 focus:ring-amber-400 focus:border-amber-400 transition-all"
                                    type="search" name="search" placeholder="Search materials..." value="{{ request('search') }}">
                                <button class="bg-white hover:bg-amber-400 text-gray-800 px-4 py-2 rounded-r-md border border-gray-300 transition-colors duration-200" type="submit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- Statistics Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Statistics</h1>
                    </div>

                    <!-- Chart -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Material Approval Status</h2>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                            <canvas id="approvalChart" class="max-h-64"></canvas>
                        </div>
                    </div>

                    <!-- Table -->
                    @if($stats->isEmpty())
                        <div class="text-center py-8 text-gray-800">
                            <p>No statistics available.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold tracking-wider">
                                        <th class="p-3 text-left">Uploader</th>
                                        <th class="p-3 text-left">Material</th>
                                        <th class="p-3 text-left">Course</th>
                                        <th class="p-3 text-left">Approved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats as $stat)
                                        <tr class="border-b hover:bg-amber-50 transition-colors duration-150">
                                            <td class="p-3 text-gray-800">{{ $stat->name }}</td>
                                            <td class="p-3 text-gray-800">{{ $stat->title }}</td>
                                            <td class="p-3 text-gray-800">{{ $stat->course_name }}</td>
                                            <td class="p-3">
                                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $stat->approved ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                    {{ $stat->approved ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('approvalChart').getContext('2d');
            const stats = @json($stats);

            const approvedCount = stats.filter(stat => stat.approved).length;
            const notApprovedCount = stats.length - approvedCount;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Approved', 'Not Approved'],
                    datasets: [{
                        label: 'Material Status',
                        data: [approvedCount, notApprovedCount],
                        backgroundColor: [
                            'rgba(251, 191, 36, 0.6)', // Amber
                            'rgba(156, 163, 175, 0.6)', // Gray
                        ],
                        borderColor: [
                            'rgba(251, 191, 36, 1)',
                            'rgba(156, 163, 175, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#1F2937',
                            },
                            grid: {
                                color: 'rgba(209, 213, 219, 0.3)',
                            }
                        },
                        x: {
                            ticks: {
                                color: '#1F2937',
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#1F2937',
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
