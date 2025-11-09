<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gradient">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-6">

        <div class="glass p-6 rounded-xl shadow hover:shadow-lg">
            <h3 class="text-xl font-bold text-pink-600 mb-2">Chào mừng, {{ Auth::user()->name }}! ✨</h3>
            <p class="text-gray-700">Bạn có thể quản lý chủ đề, bình luận và hồ sơ cá nhân tại đây.</p>
        </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach([
        ['label'=>'Số chủ đề đã tạo','count'=>$threadsCount ?? 0],
        ['label'=>'Số bình luận đã đăng','count'=>$postsCount ?? 0],
        ['label'=>'Chủ đề mới tuần này','count'=>$newThreadsThisWeek ?? 0],
        ['label'=>'Bình luận tuần này','count'=>$newPostsThisWeek ?? 0],
    ] as $stat)
    <div class="glass p-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02] glow-card">
        <h4 class="text-lg font-semibold text-pink-700">{{$stat['label']}}</h4>
        <p class="text-gray-800 text-3xl mt-2 font-bold">{{$stat['count']}}</p>
    </div>
    @endforeach
</div>

<div class="glass p-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02] glow-card">
    <h4 class="text-lg font-bold text-pink-600 mb-4">Thống kê hoạt động theo ngày</h4>
    <canvas id="activityChart" class="w-full h-64"></canvas>
</div>

<div class="glass p-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02] glow-card">
    <h4 class="text-lg font-bold text-pink-600 mb-3">Liên kết nhanh</h4>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('threads.index') }}" class="btn-soft px-4 py-2 rounded-xl shadow
               bg-gradient-to-r from-pink-300 via-pink-200 to-yellow-200
               hover:from-pink-400 hover:via-pink-300 hover:to-yellow-300
               active:scale-95 active:shadow-inner
               transition transform duration-200 glow-btn">
            Xem tất cả chủ đề
        </a>
        <a href="{{ route('threads.create') }}" class="btn-soft px-4 py-2 rounded-xl shadow
               bg-gradient-to-r from-pink-300 via-pink-200 to-yellow-200
               hover:from-pink-400 hover:via-pink-300 hover:to-yellow-300
               active:scale-95 active:shadow-inner
               transition transform duration-200 glow-btn">
            Tạo chủ đề mới
        </a>
        <a href="{{ route('profile.edit') }}" class="btn-soft px-4 py-2 rounded-xl shadow
               bg-gradient-to-r from-pink-300 via-pink-200 to-yellow-200
               hover:from-pink-400 hover:via-pink-300 hover:to-yellow-300
               active:scale-95 active:shadow-inner
               transition transform duration-200 glow-btn">
            Chỉnh sửa hồ sơ
        </a>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx=document.getElementById('activityChart').getContext('2d');
        new Chart(ctx,{
            type:'line',
            data:{
                labels:{!! json_encode($chartDates ?? []) !!},
                datasets:[
                    {
                        label:'Chủ đề',
                        data:{!! json_encode($chartThreads ?? []) !!},
                        borderColor:'rgba(255,182,193,1)',
                        backgroundColor:'rgba(255,182,193,0.2)',
                        tension:0.4, fill:true, pointRadius:5, pointHoverRadius:7
                    },
                    {
                        label:'Bình luận',
                        data:{!! json_encode($chartPosts ?? []) !!},
                        borderColor:'rgba(255,105,180,1)',
                        backgroundColor:'rgba(255,105,180,0.2)',
                        tension:0.4, fill:true, pointRadius:5, pointHoverRadius:7
                    }
                ]
            },
            options:{
                responsive:true,
                plugins:{legend:{labels:{color:'#FF69B4', font:{size:14}}}},
                scales:{
                    x:{ticks:{color:'#FF1493'}, grid:{color:'rgba(255,192,203,0.1)'}},
                    y:{ticks:{color:'#FF1493'}, grid:{color:'rgba(255,192,203,0.1)'}}
                }
            }
        });
    </script>
<style>
/* Glow animation cho card */
.glow-card {
    position: relative;
    z-index: 0;
}
.glow-card::before {
    content: '';
    position: absolute;
    top: -3px; left: -3px; right: -3px; bottom: -3px;
    background: linear-gradient(270deg, #fbc2eb, #a1c4fd, #ff9a9e, #fad0c4);
    background-size: 600% 600%;
    border-radius: inherit;
    filter: blur(6px);
    opacity: 0;
    transition: opacity 0.3s;
    z-index: -1;
    animation: gradientGlow 6s ease infinite;
}
.glow-card:hover::before {
    opacity: 0.5;
}

/* Glow animation cho nút */
.glow-btn {
    position: relative;
    z-index: 0;
}
.glow-btn::before {
    content: '';
    position: absolute;
    top: -5px; left: -5px; right: -5px; bottom: -5px;
    background: linear-gradient(270deg, #ff9a9e, #fad0c4, #fbc2eb, #a1c4fd);
    background-size: 600% 600%;
    border-radius: inherit;
    filter: blur(8px);
    opacity: 0;
    transition: opacity 0.3s;
    z-index: -1;
    animation: gradientGlow 6s ease infinite;
}
.glow-btn:hover::before {
    opacity: 0.6;
}

@keyframes gradientGlow {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
</style>
</x-app-layout>
