<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gradient">{{ $thread->title }}</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <!-- Thread Content -->
            <div class="glass p-6 shadow-md hover:shadow-lg transition-shadow duration-300 transform hover:scale-[1.01]">
                <p class="text-gray-800 mb-2">{{ $thread->body }}</p>
                <p class="text-gray-700 font-medium mb-2">Người tạo: {{ $thread->user->name }}</p>

                @php $images = $thread->images ? json_decode($thread->images) : []; @endphp
                @if(count($images)>0)
                    <div x-data="{ open:false, imgSrc:'' }" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                        @foreach($images as $img)
                            <img src="{{ asset('storage/'.$img) }}" 
                                 class="w-full h-40 object-cover rounded-xl shadow hover:shadow-lg hover:scale-105 transition transform cursor-pointer"
                                 @click="imgSrc='{{ asset('storage/'.$img) }}'; open=true">
                        @endforeach
                        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50" style="display:none;">
                            <div class="relative max-w-4xl w-full">
                                <button @click="open=false" class="absolute top-2 right-2 text-white text-3xl font-bold">&times;</button>
                                <img :src="imgSrc" class="w-full max-h-[80vh] object-contain rounded-xl shadow-lg">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Reaction -->
            <div id="reactions-{{ $thread->id }}" class="flex items-center gap-3 mt-4">
                @foreach(['like','love','haha','wow','sad','angry'] as $type)
                    <button class="reaction-btn px-2 py-1 rounded-xl hover:bg-pink-50 transition transform hover:scale-110 shadow-sm" data-type="{{ $type }}">
                        @if($type=='like') 👍 @elseif($type=='love') ❤️ @elseif($type=='haha') 😂 @elseif($type=='wow') 😮 @elseif($type=='sad') 😢 @else 😡 @endif
                    </button>
                @endforeach
                <span id="reaction-count-{{ $thread->id }}" class="ml-2 text-gray-700 font-medium">{{ $thread->reactions->count() ?? 0 }} cảm xúc</span>
            </div>

            <!-- Comments -->
            <h3 class="text-xl font-bold text-pink-600 mt-6">Bình luận</h3>
            <ul class="space-y-4">
                @forelse($thread->posts as $post)
                    <li class="glass p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01]">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium text-gray-800">{{ $post->user->name }}</span>
                            <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $post->content }}</p>
                    </li>
                @empty
                    <li class="text-gray-600 italic">Chưa có bình luận nào.</li>
                @endforelse
            </ul>

            @auth
                <form action="{{ route('posts.store') }}" method="POST" class="space-y-3 glass p-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01]">
                    @csrf
                    <textarea name="content" rows="4" placeholder="Viết bình luận..." class="w-full border rounded-xl px-3 py-2 focus:ring-pink-100 focus:border-pink-300 text-gray-800 transition-all duration-200"></textarea>
                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 rounded-xl font-semibold text-white shadow-md
                                       bg-gradient-to-r from-pink-400 via-pink-300 to-yellow-200
                                       hover:from-pink-500 hover:via-pink-400 hover:to-yellow-300
                                       active:scale-95 active:shadow-inner
                                       transition transform duration-200 glow-btn">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
            @endauth

        </div>

       <!-- Sidebar -->
<div class="space-y-6">
    <!-- Người dùng tích cực -->
    <div class="glass p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.01] glow-card">
        <h4 class="font-bold text-pink-600 mb-3">⭐ Người dùng tích cực</h4>
        <ul class="space-y-2">
            @foreach($topUsers ?? [] as $user)
                <li class="flex justify-between items-center transition transform hover:scale-[1.02] glow-card">
                    <span class="text-gray-800 font-medium">{{ $user->name }}</span>
                    <span class="text-gray-600 text-sm">({{ $user->posts_count }} bình luận)</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>

    <script>
        document.querySelectorAll('.reaction-btn').forEach(btn=>{
            btn.addEventListener('click',()=>{
                const type=btn.dataset.type;
                const threadId={{ $thread->id }};
                fetch(`/threads/${threadId}/react`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
                    body:JSON.stringify({type})
                })
                .then(res=>res.json())
                .then(data=>{
                    document.getElementById(`reaction-count-${threadId}`).innerText=`${data.total} cảm xúc`;
                });
            });
        });
    </script>

    <!-- Glow Animation Style -->
    <style>
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

    </style>

</x-app-layout>
