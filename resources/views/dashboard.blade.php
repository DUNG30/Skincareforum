<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-yellow-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Chào mừng -->
        <div class="bg-yellow-50 p-6 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-xl font-bold text-yellow-800 mb-2">Chào mừng, {{ Auth::user()->name }}! ✨</h3>
            <p class="text-gray-600">Bạn có thể quản lý các chủ đề, bình luận và hồ sơ cá nhân tại đây.</p>
        </div>

        <!-- Thống kê nhanh -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-yellow-100 p-6 rounded-xl shadow hover:bg-yellow-200 hover:shadow-lg transition-all duration-300">
                <h4 class="text-lg font-semibold text-yellow-900">Số chủ đề đã tạo</h4>
                <p class="text-gray-700 text-3xl mt-2 font-bold">{{ $threadsCount ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-xl shadow hover:bg-yellow-200 hover:shadow-lg transition-all duration-300">
                <h4 class="text-lg font-semibold text-yellow-900">Số bình luận đã đăng</h4>
                <p class="text-gray-700 text-3xl mt-2 font-bold">{{ $postsCount ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-xl shadow hover:bg-yellow-200 hover:shadow-lg transition-all duration-300">
                <h4 class="text-lg font-semibold text-yellow-900">Chủ đề mới tuần này</h4>
                <p class="text-gray-700 text-3xl mt-2 font-bold">{{ $newThreadsThisWeek ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-xl shadow hover:bg-yellow-200 hover:shadow-lg transition-all duration-300">
                <h4 class="text-lg font-semibold text-yellow-900">Bình luận tuần này</h4>
                <p class="text-gray-700 text-3xl mt-2 font-bold">{{ $newPostsThisWeek ?? 0 }}</p>
            </div>
        </div>

        <!-- Biểu đồ hoạt động -->
        <div class="bg-yellow-50 p-6 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
            <h4 class="text-lg font-bold text-yellow-800 mb-4">Thống kê hoạt động theo ngày</h4>
            <canvas id="activityChart" class="w-full h-64"></canvas>
        </div>

        <!-- Quick Links -->
        <div class="bg-yellow-50 p-6 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
            <h4 class="text-lg font-bold text-yellow-800 mb-3">Liên kết nhanh</h4>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('threads.index') }}" 
                   class="bg-yellow-100 text-yellow-900 px-4 py-2 rounded-xl shadow hover:bg-yellow-200 transition-all duration-300">
                   Xem tất cả chủ đề
                </a>
                <a href="{{ route('threads.create') }}" 
                   class="bg-yellow-100 text-yellow-900 px-4 py-2 rounded-xl shadow hover:bg-yellow-200 transition-all duration-300">
                   Tạo chủ đề mới
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="bg-yellow-100 text-yellow-900 px-4 py-2 rounded-xl shadow hover:bg-yellow-200 transition-all duration-300">
                   Chỉnh sửa hồ sơ
                </a>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartDates ?? []) !!},
                datasets: [
                    {
                        label: 'Chủ đề',
                        data: {!! json_encode($chartThreads ?? []) !!},
                        borderColor: 'rgba(218, 165, 32, 1)',
                        backgroundColor: 'rgba(218, 165, 32, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Bình luận',
                        data: {!! json_encode($chartPosts ?? []) !!},
                        borderColor: 'rgba(255, 215, 0, 1)',
                        backgroundColor: 'rgba(255, 215, 0, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#D4AF37',
                            font: { size: 14 }
                        }
                    },
                },
                scales: {
                    x: {
                        ticks: { color: '#D4AF37' },
                        grid: { color: 'rgba(212, 175, 55, 0.1)' }
                    },
                    y: {
                        ticks: { color: '#D4AF37' },
                        grid: { color: 'rgba(212, 175, 55, 0.1)' }
                    }
                }
            }
        });
    </script>
</x-app-layout>
