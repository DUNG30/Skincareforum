<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight glow-text">
            Chỉnh sửa bài viết
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Thông báo thành công --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded shadow-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Thẻ thông tin bài viết hiện tại --}}
        <div class="bg-gradient-to-r from-yellow-100 via-pink-100 to-purple-100 p-4 rounded-lg shadow-sm border border-gray-200">
            <h3 class="font-semibold text-lg text-gray-800 mb-2">Preview bài viết hiện tại</h3>
            <p class="text-gray-600 mb-2"><strong>Tiêu đề:</strong> {{ $post->title }}</p>
            <p class="text-gray-600 mb-2"><strong>Chuyên mục:</strong> {{ $post->category }}</p>
            <div class="text-gray-700">
                {!! nl2br(e($post->content)) !!}
            </div>

            @if ($post->media && count($post->media) > 0)
                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($post->media as $file)
                        @php $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <img src="{{ asset($file) }}" class="rounded shadow w-full object-cover">
                        @elseif(in_array($ext, ['mp4','mov','avi','mkv','webm']))
                            <video controls class="rounded shadow w-full">
                                <source src="{{ asset($file) }}">
                            </video>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Form chỉnh sửa --}}
        <div class="glass overflow-hidden shadow-xl sm:rounded-2xl p-6 relative">

            <form method="POST" action="{{ route('forum.update', $post) }}" enctype="multipart/form-data" id="post-form">
                @csrf
                @method('PUT')

                {{-- Tiêu đề --}}
                <div class="mb-5">
                    <label for="title" class="block font-medium text-gray-700">Tiêu đề</label>
                    <input id="title" name="title" type="text"
                           class="mt-1 block w-full text-lg border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 transition"
                           value="{{ old('title', $post->title) }}" required autofocus>
                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nội dung --}}
                <div class="mb-5">
                    <label for="content" class="block font-medium text-gray-700">Nội dung</label>
                    <textarea id="content" name="content" rows="6"
                              class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition"
                              required>{{ old('content', $post->content) }}</textarea>
                    @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Chuyên mục --}}
                <div class="mb-5">
                    <label for="category" class="block font-medium text-gray-700">Chuyên mục</label>
                    <input id="category" name="category" type="text"
                           class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-purple-300 focus:border-purple-400 transition"
                           value="{{ old('category', $post->category) }}" required>
                    @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Hashtags --}}
                <div class="mb-5 relative">
                    <label for="hashtags" class="block font-medium text-gray-700">Hashtags (ngăn cách bởi dấu ,)</label>
                    <input id="hashtags" name="hashtags" type="text"
                           class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition"
                           value="{{ old('hashtags', $post->hashtags) }}">
                </div>

                {{-- Upload Media --}}
                <div class="mb-6">
                    <label class="block font-medium text-gray-700">Thêm ảnh/video (tối đa 10 file)</label>
                    <div id="drop-zone"
                         class="mt-3 border-4 border-dashed border-pink-400/50 rounded-2xl p-10 text-center cursor-pointer hover:border-pink-500 hover:bg-pink-50/30 transition-all duration-300">
                        <svg class="mx-auto h-16 w-16 text-pink-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <p class="text-xl font-semibold text-pink-600">Kéo & thả file vào đây</p>
                        <p class="text-gray-500 mt-2">hoặc <span class="text-pink-600 underline">click để chọn</span></p>
                        <input type="file" id="media" name="media[]" multiple accept="image/*,video/*" class="hidden" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('media')" />
                    <div id="preview" class="flex flex-wrap gap-4 mt-6"></div>
                </div>

                {{-- Nút cập nhật và xóa --}}
                <div class="flex justify-center mt-8 gap-4">
                    <button type="submit"
                        class="btn-glow px-10 py-4 text-white font-bold text-xl rounded-full shadow-2xl transition-all hover:shadow-[0_0_30px_#fd1d1d,0_0_50px_#833ab4] hover:-translate-y-2 transform">
                        Cập nhật
                    </button>

                    <form method="POST" action="{{ route('forum.destroy', $post) }}" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn-glow px-8 py-4 bg-red-600 text-white font-bold text-xl rounded-full shadow-2xl transition-all hover:bg-red-700 hover:shadow-[0_0_30px_#fd1d1d,0_0_50px_#833ab4] hover:-translate-y-2 transform">
                            Xóa bài
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>

    {{-- Script preview media giống create --}}
    <script>
        const dropZone = document.getElementById('drop-zone');
        const mediaInput = document.getElementById('media');
        const preview = document.getElementById('preview');
        let filesArray = [];

        dropZone.addEventListener('click', () => mediaInput.click());
        ['dragover','dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('bg-pink-100/50', 'border-pink-600'); }));
        ['dragleave','dragend','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('bg-pink-100/50', 'border-pink-600'); }));
        dropZone.addEventListener('drop', e => { e.preventDefault(); handleFiles(e.dataTransfer.files); });
        mediaInput.addEventListener('change', () => handleFiles(mediaInput.files));

        function handleFiles(files) {
            const newFiles = Array.from(files).filter(file => file.type.startsWith('image/') || file.type.startsWith('video/'));
            if (filesArray.length + newFiles.length > 10) { alert('Tối đa chỉ được upload 10 file thôi!'); return; }
            filesArray.push(...newFiles);
            renderPreview();
        }

        function renderPreview() {
            preview.innerHTML = '';
            filesArray.forEach((file,index) => {
                const div = document.createElement('div'); div.className='relative group';
                if(file.type.startsWith('image/')) div.innerHTML = `<img src="${URL.createObjectURL(file)}" class="h-32 w-32 object-cover rounded-xl shadow-lg">`;
                else div.innerHTML = `<video src="${URL.createObjectURL(file)}" controls class="h-32 w-32 object-cover rounded-xl shadow-lg"></video><div class="absolute inset-0 bg-black/30 rounded-xl flex items-center justify-center"><svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></div>`;
                const removeBtn = document.createElement('button'); removeBtn.type='button'; removeBtn.innerHTML='×';
                removeBtn.className='absolute -top-3 -right-3 bg-red-600 text-white w-9 h-9 rounded-full text-2xl font-bold opacity-0 group-hover:opacity-100 transition hover:bg-red-700 shadow-lg';
                removeBtn.onclick=()=>{filesArray.splice(index,1); renderPreview();}
                div.appendChild(removeBtn); preview.appendChild(div);
            });
        }

        document.getElementById('post-form').addEventListener('submit',()=>{const dt=new DataTransfer(); filesArray.forEach(f=>dt.items.add(f)); mediaInput.files=dt.files;});
    </script>

    {{-- CSS Glow và Glass --}}
    <style>
        .glass { background: rgba(255,255,255,0.25); backdrop-filter: blur(16px); border:1px solid rgba(255,255,255,0.3); border-radius: 1rem; }
        .glow-text { text-shadow: 0 0 10px #fd1d1d, 0 0 20px #e1306c, 0 0 30px #833ab4; }
        .btn-glow { background: linear-gradient(45deg, #fd1d1d, #e1306c, #833ab4, #5851db); position: relative; overflow: hidden; }
        .btn-glow:before { content: ''; position: absolute; top:-50%; left:-50%; width:200%; height:200%; background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent); transform: rotate(45deg); transition: all 0.6s; }
        .btn-glow:hover:before { animation: shine 0.8s ease-in-out; }
        @keyframes shine { 0% { transform: translateX(-100%) translateY(-100%) rotate(45deg);} 100% { transform: translateX(100%) translateY(100%) rotate(45deg); } }
    </style>
</x-app-layout>
