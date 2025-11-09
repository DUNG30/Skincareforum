<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gradient leading-tight">
            Diễn đàn Mỹ Phẩm ✨
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Danh sách chủ đề chính (8/12 cột) -->
        <div class="lg:col-span-2 space-y-4">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-xl glass text-green-800 shadow-md hover:shadow-lg transition transform hover:scale-[1.01]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Danh sách chủ đề</h3>
                <a href="{{ route('threads.create') }}" 
                   class="btn-soft px-4 py-2 rounded-xl shadow text-white
                          bg-gradient-to-r from-pink-300 via-pink-200 to-yellow-200
                          hover:from-pink-400 hover:via-pink-300 hover:to-yellow-300
                          active:scale-95 active:shadow-inner
                          transition transform duration-200 glow-btn">
                    Tạo chủ đề mới
                </a>
            </div>

            <ul class="space-y-4">
                @forelse($threads as $thread)
                    <li class="glass p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01]">
                        <a href="{{ route('threads.show', $thread) }}" 
                           class="text-lg font-semibold text-pink-600 hover:text-pink-500 hover:underline transition duration-200">
                            {{ $thread->title }}
                        </a>
                        <div class="text-gray-500 text-sm mt-1 flex justify-between">
                            <span>Người tạo: {{ $thread->user->name }}</span>
                            <span>Bình luận: {{ $thread->posts->count() }}</span>
                        </div>
                        <p class="text-gray-700 mt-2 line-clamp-2">{{ $thread->body }}</p>
                    </li>
                @empty
                    <li class="text-gray-500 italic">Chưa có chủ đề nào. Hãy tạo chủ đề đầu tiên!</li>
                @endforelse
            </ul>
        </div>

        <!-- Sidebar (4/12 cột) -->
        <div class="space-y-6">
            <!-- Top chủ đề hot -->
            <div class="glass p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01] glow-card">
                <h4 class="font-bold text-pink-600 mb-3">🔥 Top chủ đề hot</h4>
                <ul class="space-y-2">
                    @foreach($topThreads ?? [] as $topThread)
                        <li>
                            <a href="{{ route('threads.show', $topThread) }}" 
                               class="text-pink-500 hover:text-pink-400 hover:underline font-medium transition duration-200">
                                {{ $topThread->title }}
                            </a>
                            <span class="text-gray-500 text-sm">({{ $topThread->posts_count }} bình luận)</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Người dùng năng động nhất -->
            <div class="glass p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01] glow-card">
                <h4 class="font-bold text-pink-600 mb-3">⭐ Người dùng năng động</h4>
                <ul class="space-y-2">
                    @foreach($topUsers ?? [] as $user)
                        <li class="flex justify-between items-center transition transform hover:scale-[1.02]">
                            <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                            <span class="text-gray-500 text-sm">({{ $user->posts_count }} bình luận)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

    <style>
        /* Glow animation cho button */
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

        /* Glow animation cho card sidebar */
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

        @keyframes gradientGlow {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
    </style>

</x-app-layout>
