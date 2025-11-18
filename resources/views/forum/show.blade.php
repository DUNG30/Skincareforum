<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-700 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-600 border border-green-300 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- KHUNG BÀI VIẾT --}}
        <div class="bg-white rounded-3xl shadow-lg p-6 space-y-6 border border-pink-100">

            {{-- Info --}}
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                <span>
                    Đăng bởi 
                    <span class="font-medium text-pink-600">
                        {{ $post->user->name ?? 'Người dùng ẩn' }}
                    </span>
                </span>

                <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-semibold border border-pink-200">
                    {{ $post->category }}
                </span>

                <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
            </div>

            {{-- Nội dung --}}
            <div class="text-gray-700 whitespace-pre-line leading-relaxed text-lg space-y-4">
                @php
                    $lines = preg_split('/\r\n|\r|\n/', $post->content);
                @endphp

                @foreach($lines as $line)
                    @if(trim($line))
                        <p class="p-3 border-l-4 border-pink-300 bg-pink-50 rounded-lg shadow-sm">
                            {{ $line }}
                        </p>
                    @endif
                @endforeach
            </div>

           @php
    // Nếu media là string JSON thì decode, nếu đã là array thì dùng luôn
    $mediaFiles = is_string($post->media) ? json_decode($post->media, true) : ($post->media ?? []);
@endphp

@if(count($post->media) > 0)
    <div class="mt-6 flex flex-wrap gap-3">
        @foreach($post->media as $file)
            @php
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $fileUrl = asset('storage/'.$file);
            @endphp
            @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                <div class="flex-1 min-w-[120px] max-w-[150px] h-32 rounded-2xl overflow-hidden border border-pink-200 bg-white shadow">
                    <img src="{{ $fileUrl }}" class="w-full h-full object-cover hover:scale-105 transition duration-200" alt="">
                </div>
            @elseif(in_array($ext, ['mp4','mov','avi','webm']))
                <div class="flex-1 min-w-[120px] max-w-[150px] h-32 rounded-2xl overflow-hidden border border-pink-200 bg-white shadow">
                    <video controls class="w-full h-full object-cover">
                        <source src="{{ $fileUrl }}" type="video/{{ $ext }}">
                    </video>
                </div>
            @endif
        @endforeach
    </div>
@endif
            {{-- Reaction --}}
            <div class="mt-4 flex flex-wrap items-center gap-4">

                <div class="relative">
                    <button id="react-btn"
                        class="px-4 py-2 bg-pink-100 text-pink-600 rounded-full shadow hover:bg-pink-200 transition text-sm font-medium">
                        <span id="user-react">
                            {{ optional($post->reactions->where('user_id', auth()->id())->first())->type }}
                        </span>
                        Reaction
                    </button>

                    <div id="react-box" 
                         class="hidden absolute z-50 left-0 -top-16 bg-white border border-pink-200 px-3 py-2 rounded-2xl shadow flex space-x-2">
                        <button class="react-option text-xl" data-type="like">👍</button>
                        <button class="react-option text-xl" data-type="love">❤️</button>
                        <button class="react-option text-xl" data-type="haha">😂</button>
                        <button class="react-option text-xl" data-type="wow">😮</button>
                        <button class="react-option text-xl" data-type="sad">😢</button>
                        <button class="react-option text-xl" data-type="angry">😡</button>
                    </div>
                </div>

                <div id="react-count" class="text-sm text-gray-600">
                    @foreach ($post->reactions->groupBy('type') as $type => $group)
                        <span class="mr-2">{{ $type }}: {{ count($group) }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Sửa / Xóa --}}
            @can('update', $post)
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('forum.edit', $post) }}" 
                        class="px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full shadow transition font-semibold">
                        Chỉnh sửa
                    </a>

                    <form action="{{ route('forum.destroy', $post) }}" method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết?');">
                        @csrf
                        @method('DELETE')
                        <button class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition font-semibold">
                            Xóa
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        {{-- KHUNG BÌNH LUẬN --}}
        <div class="bg-white rounded-3xl shadow-lg p-6 space-y-4 border border-pink-100">
            <h3 class="text-lg font-bold mb-2 text-gray-700">Bình luận</h3>

            @foreach($post->comments as $c)
                <div class="border border-pink-200 bg-pink-50 p-4 rounded-2xl space-y-1 shadow-sm">
                    <p class="text-sm text-gray-600">
                        {{ $c->user->name ?? 'Người dùng ẩn' }} • {{ $c->created_at->diffForHumans() }}
                    </p>
                    <p class="text-gray-700">{{ $c->content }}</p>
                </div>
            @endforeach

            @auth
                <form action="{{ route('forum.comment', $post) }}" method="POST" class="mt-4 space-y-3">
                    @csrf
                    <textarea name="comment" rows="3" required
                        class="w-full border border-pink-300 rounded-2xl p-3 bg-pink-50 text-gray-700 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-pink-300 focus:outline-none"
                        placeholder="Viết bình luận..."></textarea>

                    {{-- NÚT GỬI PASTEL --}}
                    <button
                        class="px-5 py-2 bg-pink-300 hover:bg-pink-400 text-white rounded-full font-bold shadow-md transition">
                        Gửi bình luận
                    </button>
                </form>
            @endauth
        </div>

    </div>

    {{-- Script Reaction --}}
    <script>
        const csrf = '{{ csrf_token() }}';
        const btn = document.getElementById('react-btn');
        const box = document.getElementById('react-box');
        const countBox = document.getElementById('react-count');

        btn.addEventListener('mouseenter', () => box.classList.remove('hidden'));
        btn.addEventListener('mouseleave', () => setTimeout(()=>{ if(!box.matches(':hover')) box.classList.add('hidden'); }, 120));
        box.addEventListener('mouseleave', () => box.classList.add('hidden'));

        document.querySelectorAll('.react-option').forEach(b => {
            b.addEventListener('click', () => {
                let type = b.getAttribute('data-type');
                fetch("{{ route('post.react', $post) }}", {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': csrf,'Accept':'application/json'},
                    body: JSON.stringify({ type })
                })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('user-react').innerText = data.user_reaction ?? '';
                    countBox.innerHTML = '';
                    for (const t in data.counts) countBox.innerHTML += `<span class="mr-2">${t}: ${data.counts[t]}</span>`;
                });
            });
        });
    </script>
<style>
/* ============================
   TONE HỒNG PASTEL TOÀN TRANG
   ============================ */
.bg-pink-50 { background-color: #fff0f6 !important; }
.bg-pink-100 { background-color: #ffe4ef !important; }
.bg-pink-200 { background-color: #ffcadc !important; }
.bg-pink-300 { background-color: #f8a8c8 !important; }
.bg-pink-400 { background-color: #f07cab !important; }
.bg-pink-500 { background-color: #e44d8c !important; }

/* ============================
   FORM & CONTENT UI
   ============================ */
.border-pink-100 { border-color: #ffd6e7 !important; }
.border-pink-200 { border-color: #ffb8cf !important; }
.text-pink-600 { color: #d63384 !important; }

/* Custom blockquote đẹp */
p.pink-block {
    background: #fff0f7;
    border-left: 4px solid #f07cab;
    border-radius: 12px;
    padding: 12px 14px;
    color: #555;
}

/* ============================
   IMAGE HOVER
   ============================ */
img:hover {
    transform: scale(1.05);
    transition: 0.3s ease;
    filter: brightness(1.06);
}

/* ============================
   REACTION BUTTON
   ============================ */
#react-btn {
    transition: 0.25s;
    font-weight: 600;
}

#react-btn:hover {
    background-color: #f8a8c8 !important;
    color: #8a004e !important;
}

/* Reaction emoji hover */
.react-option {
    transition: 0.15s;
}

.react-option:hover {
    transform: scale(1.25);
}

/* ============================
   ACTION BUTTONS (Sửa / Xóa)
   ============================ */

/* Chỉnh sửa */
a.bg-yellow-400 {
    background-color: #facc15 !important;
    color: white !important;
    transition: 0.25s;
}

a.bg-yellow-400:hover {
    background-color: #eab308 !important;
}

/* Xóa */
button.bg-red-500 {
    background-color: #ef4444 !important;
    transition: 0.25s;
}

button.bg-red-500:hover {
    background-color: #dc2626 !important;
    color: white !important;
}

/* ============================
   COMMENT BUTTON
   ============================ */
button.bg-pink-300 {
    background-color: #f8a8c8 !important;
    font-weight: 700;
    transition: 0.25s;
}

button.bg-pink-300:hover {
    background-color: #f07cab !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(240, 124, 171, 0.5);
}

/* Comment box */
textarea {
    transition: 0.3s;
}

textarea:focus {
    background-color: #ffe8f3 !important;
}

/* ============================
   CARD UI
   ============================ */
.shadow-lg { box-shadow: 0 8px 18px rgba(0,0,0,0.08) !important; }
.shadow-md { box-shadow: 0 4px 12px rgba(0,0,0,0.07) !important; }

/* ============================
   COMMENT BLOCK
   ============================ */
.comment-item:hover {
    background: #ffe8f3 !important;
    transition: 0.2s;
}
</style>
</x-app-layout>
