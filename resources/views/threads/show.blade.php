<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-yellow-600 leading-tight">
            {{ $thread->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Nội dung chủ đề và bình luận -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Chủ đề -->
            <div class="bg-white p-6 rounded-xl shadow">
                <p class="mb-4">{{ $thread->body }}</p>
                <p class="text-gray-500 mb-4">Người tạo: {{ $thread->user->name }}</p>

                <!-- Ảnh bài đăng -->
                @php
                    $images = $thread->images ? json_decode($thread->images) : [];
                @endphp

                @if($thread->images->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        @foreach($thread->images as $img)
            <img src="{{ asset('storage/'.$img->image_path) }}" 
                 class="w-full h-40 object-cover rounded-xl shadow hover:scale-105 cursor-pointer transition" 
                 alt="Ảnh bài đăng">
        @endforeach

                        <!-- Lightbox -->
                        <div x-show="open" x-transition
                             class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
                             style="display: none;">
                            <div class="relative max-w-4xl w-full">
                                <button @click="open=false" 
                                        class="absolute top-2 right-2 text-white text-3xl font-bold">&times;</button>
                                <img :src="imgSrc" class="w-full max-h-[80vh] object-contain rounded-xl shadow-lg">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Hashtags -->
            @if($thread->hashtags)
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach(explode(' ', $thread->hashtags) as $tag)
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm hover:bg-yellow-200 transition cursor-pointer">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Bình luận -->
            <h3 class="text-xl font-bold text-yellow-200">Bình luận</h3>
            <ul class="space-y-4">
                @forelse($thread->posts as $post)
                    <li class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
                            <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <p>{{ $post->content }}</p>
                    </li>
                @empty
                    <li class="text-gray-500">Chưa có bình luận nào.</li>
                @endforelse
            </ul>

            <!-- Form bình luận -->
            @auth
                <form action="{{ route('posts.store') }}" method="POST" class="space-y-3 bg-white p-6 rounded-xl shadow">
                    @csrf
                    <textarea name="content" rows="4" placeholder="Viết bình luận..." 
                              class="w-full border rounded px-3 py-2 focus:ring-yellow-100 focus:border-yellow-200" required></textarea>
                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded shadow hover:bg-yellow-200 transition">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
            @endauth

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Người dùng tích cực nhất -->
            <div class="bg-yellow-50 p-4 rounded-xl shadow">
                <h4 class="font-bold text-yellow-800 mb-3">⭐ Người dùng tích cực</h4>
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
