<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-yellow-200 leading-tight">
            Diễn đàn Mỹ Phẩm ✨
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Danh sách chủ đề chính (8/12 cột) -->
        <div class="lg:col-span-2 space-y-4">
            @if(session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Danh sách chủ đề</h3>
                <a href="{{ route('threads.create') }}" 
                   class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded shadow hover:bg-yellow-200 transition">
                   Tạo chủ đề mới
                </a>
            </div>

            <ul class="space-y-4">
                @forelse($threads as $thread)
                    <li class="bg-white shadow-sm rounded-xl p-4 hover:shadow-md transition">
                        <a href="{{ route('threads.show', $thread) }}" 
                           class="text-lg font-semibold text-pink-600 hover:underline">
                            {{ $thread->title }}
                        </a>
                        <div class="text-gray-500 text-sm mt-1 flex justify-between">
                            <span>Người tạo: {{ $thread->user->name }}</span>
                            <span>Bình luận: {{ $thread->posts->count() }}</span>
                        </div>
                        <p class="text-gray-700 mt-2 line-clamp-2">{{ $thread->body }}</p>
                    </li>
                @empty
                    <li class="text-gray-500">Chưa có chủ đề nào. Hãy tạo chủ đề đầu tiên!</li>
                @endforelse
            </ul>
        </div>

        <!-- Sidebar (4/12 cột) -->
        <div class="space-y-6">
            <!-- Top chủ đề hot -->
            <div class="bg-yellow-50 p-4 rounded-xl shadow">
                <h4 class="font-bold text-yellow-800 mb-3">🔥 Top chủ đề hot</h4>
                <ul class="space-y-2">
                    @foreach($topThreads ?? [] as $topThread)
                        <li>
                            <a href="{{ route('threads.show', $topThread) }}" 
                               class="text-pink-600 hover:underline font-medium">
                                {{ $topThread->title }}
                            </a>
                            <span class="text-gray-500 text-sm">({{ $topThread->posts_count }} bình luận)</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Người dùng năng động nhất -->
            <div class="bg-yellow-50 p-4 rounded-xl shadow">
                <h4 class="font-bold text-yellow-800 mb-3">⭐ Người dùng năng động</h4>
                <ul class="space-y-2">
                    @foreach($topUsers ?? [] as $user)
                        <li class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                            <span class="text-gray-500 text-sm">({{ $user->posts_count }} bình luận)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</x-app-layout>
