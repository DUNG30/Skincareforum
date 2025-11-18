<x-app-layout>
    <div class="py-12 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @forelse($posts as $post)
            @php
                $hasLiked   = $post->reactions->contains('user_id', auth()->id());
                $likeCount  = $post->reactions_count ?? $post->reactions()->count();
            @endphp

            <article class="group relative bg-white/20 backdrop-blur-2xl rounded-3xl overflow-hidden shadow-2xl border border-purple-300/40 hover:border-purple-500 transition-all duration-500 cursor-pointer">

                <div class="absolute inset-0" onclick="window.location='{{ route('forum.show', $post) }}#comments'"></div>

                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-purple-400 to-pink-400 opacity-0 group-hover:opacity-30 blur-2xl transition-opacity duration-700 -z-10"></div>

                <!-- Header -->
                <header class="relative p-5 bg-gradient-to-r from-purple-50/70 to-pink-50/60 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 p-1 shadow-xl ring-2 ring-white/60">
                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-xl font-black text-transparent bg-clip-text bg-gradient-to-br from-purple-600 to-pink-600">
                            {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-purple-900">{{ $post->user->name }}</h3>
                        <p class="text-xs text-purple-600">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </header>

                <!-- Body -->
                <div class="relative p-6">
                    <h2 class="text-2xl font-extrabold text-purple-900 mb-3 line-clamp-2 group-hover:text-pink-600 transition duration-300">
                        {{ $post->title }}
                    </h2>
                    <p class="text-gray-700 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($post->content), 180) }}
                    </p>
                    <a href="{{ route('forum.show', $post) }}"
                       class="inline-block px-5 py-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold hover:from-pink-500 hover:to-purple-500 shadow-lg transition transform hover:-translate-y-1">
                        Xem chi tiết
                    </a>
                </div>

                <!-- Reaction Bar kiểu Facebook -->
                <div class="relative px-6 pb-5">
                    <div class="flex items-center justify-between pt-3 border-t border-purple-200/40">
                        
                        <!-- Like + Emoji Popup -->
                        <div class="relative">
                            <button id="like-btn-{{ $post->id }}" onclick="event.stopPropagation(); toggleLike({{ $post->id }})"
                                class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-purple-100 transition font-medium z-10
                                {{ $hasLiked ? 'text-red-600' : 'text-gray-600' }}">
                                <svg class="w-6 h-6 {{ $hasLiked ? 'fill-red-600' : 'fill-none' }} stroke-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span id="like-text-{{ $post->id }}">{{ $hasLiked ? 'Đã thích' : 'Thích' }}</span>
                                <span class="ml-1 font-bold" id="like-count-{{ $post->id }}">{{ $likeCount }}</span>
                            </button>

                            <!-- Emoji Popup -->
                            <div id="emoji-popup-{{ $post->id }}" class="absolute bottom-full left-0 mb-2 flex gap-2 p-2 bg-white rounded-full shadow-lg border border-gray-200 opacity-0 scale-0 transform transition-all duration-200 z-50">
                                @php $emojis = ['❤️','😆','😮','😢','😡']; @endphp
                                @foreach($emojis as $emoji)
                                    <button onclick="event.stopPropagation(); reactEmoji({{ $post->id }}, '{{ $emoji }}')"
                                        class="text-2xl hover:scale-125 transition transform">{{ $emoji }}</button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Comment -->
                        <a href="{{ route('forum.show', $post) }}#comments" onclick="event.stopPropagation()"
                           class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-purple-100 text-gray-600 font-medium z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Bình luận ({{ $post->comments->count() }})
                        </a>
                    </div>
                </div>

                <!-- Edit/Delete -->
                @auth
                    @if(Auth::id() === $post->user_id)
                        <div class="relative px-6 py-4 bg-purple-50/70 flex gap-3 border-t border-purple-200/50">
                            <a href="{{ route('forum.edit', $post) }}" onclick="event.stopPropagation()"
                               class="px-6 py-2.5 bg-purple-600 text-white rounded-full text-sm font-bold hover:bg-purple-700 transition z-10">
                                Chỉnh sửa
                            </a>
                            <form action="{{ route('forum.destroy', $post) }}" method="POST"
                                  onsubmit="event.stopPropagation(); return confirm('Xóa thật hả bé?')">
                                @csrf @method('DELETE')
                                <button class="px-6 py-2.5 bg-rose-600 text-white rounded-full text-sm font-bold hover:bg-rose-700 transition z-10">
                                    Xóa bài
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

            </article>
        @empty
            <div class="text-center py-24 text-purple-400 text-3xl font-bold">Chưa có bài nào hết á!</div>
        @endforelse

        <div class="flex justify-center mt-12">
            {{ $posts->links() }}
        </div>
    </div>

    <script>
        // Toggle Like
        function toggleLike(postId) {
            const popup = document.getElementById('emoji-popup-' + postId);
            popup.classList.toggle('opacity-100');
            popup.classList.toggle('scale-100');
        }

        // React với emoji
        function reactEmoji(postId, emoji) {
            fetch(`/post/${postId}/react`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ emoji: emoji })
            })
            .then(r => r.json())
            .then(data => {
                const text = document.getElementById('like-text-' + postId);
                const count = document.getElementById('like-count-' + postId);
                const btn = text.parentElement;

                text.innerText = emoji + ' ' + data.total;
                count.innerText = data.total;

                // Update màu
                btn.classList.add('text-red-600');
                btn.querySelector('svg').classList.add('fill-red-600');

                // Ẩn popup
                const popup = document.getElementById('emoji-popup-' + postId);
                popup.classList.remove('opacity-100', 'scale-100');
            });
        }
    </script>
</x-app-layout>
