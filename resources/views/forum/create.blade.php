<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight glow-text">
            {{ __('Tạo bài viết mới') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="glass overflow-hidden shadow-xl sm:rounded-2xl p-6 relative">

            <form method="POST" action="{{ route('forum.store') }}" enctype="multipart/form-data" id="post-form">
                @csrf

                {{-- Tiêu đề --}}
                <div class="mb-5">
                    <x-input-label for="title" :value="__('Tiêu đề')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-lg" 
                        value="{{ old('title') }}" required autofocus placeholder="Tiêu đề thật hấp dẫn nhé..." />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Nội dung --}}
                <div class="mb-5">
                    <x-input-label for="content" :value="__('Nội dung')" />
                    <textarea id="content" name="content" rows="7" required
                        class="mt-1 block w-full border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Chia sẻ cảm nhận, review, tips làm đẹp của bạn...">{{ old('content') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                </div>

                {{-- Chuyên mục --}}
                <div class="mb-5">
                    <x-input-label for="category" :value="__('Chuyên mục')" />
                    <x-text-input id="category" name="category" type="text" class="mt-1 block w-full"
                        value="{{ old('category') }}" required placeholder="VD: Son môi, Skincare, Makeup..." />
                    <x-input-error class="mt-2" :messages="$errors->get('category')" />
                </div>

                {{-- Hashtags + Gợi ý --}}
                <div class="mb-5 relative">
                    <x-input-label for="hashtags" :value="__('Hashtags (cách nhau bằng dấu phẩy)')" />
                    <x-text-input id="hashtags" name="hashtags" type="text" class="mt-1 block w-full"
                        placeholder="VD: skincare, sonmoi, review" value="{{ old('hashtags') }}" autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('hashtags')" />

                    <div id="hashtag-suggestions"
                         class="absolute z-50 top-full left-0 right-0 bg-white/20 backdrop-blur-lg border border-pink-300/30 rounded-lg mt-2 shadow-2xl max-h-60 overflow-y-auto hidden">
                        <div class="p-2 text-sm text-gray-600">Gợi ý hashtag:</div>
                    </div>
                </div>

                {{-- Upload Media --}}
                <div class="mb-6">
                    <x-input-label :value="__('Hình ảnh / Video (tối đa 10 file)')" />
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

                    {{-- Preview --}}
                    <div id="preview" class="flex flex-wrap gap-4 mt-6"></div>
                </div>

                {{-- Nút Đăng bài --}}
                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="btn-glow px-10 py-4 text-white font-bold text-xl rounded-full shadow-2xl transition-all hover:shadow-[0_0_30px_#fd1d1d,0_0_50px_#833ab4] hover:-translate-y-2 transform">
                        Tạo bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // === HASHTAG SUGGESTIONS ===
        const hashtagsInput = document.getElementById('hashtags');
        const suggestionsBox = document.getElementById('hashtag-suggestions');

        hashtagsInput.addEventListener('input', () => {
            const value = hashtagsInput.value.trim();
            const lastPart = value.split(',').pop().trim();

            if (!lastPart || lastPart.length < 2) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            // Giả lập gợi ý (thay bằng route thật của bạn)
            const suggestions = ['skincare', 'makeup', 'sonmoi', 'kemchongnang', 'review', 'tips', 'laneige', 'theordinary', 'mac', 'dior'];
            const filtered = suggestions.filter(tag => tag.toLowerCase().includes(lastPart.toLowerCase())).slice(0, 6);

            if (filtered.length === 0) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            suggestionsBox.innerHTML = filtered.map(tag => `
                <div class="px-4 py-3 hover:bg-pink-500/30 cursor-pointer text-white font-medium border-b border-pink-300/20 last:border-0"
                     onclick="selectHashtag('${tag}')">
                    #${tag}
                </div>
            `).join('');

            suggestionsBox.classList.remove('hidden');
        });

        function selectHashtag(tag) {
            let parts = hashtagsInput.value.split(',');
            parts.pop();
            parts.push(tag);
            hashtagsInput.value = parts.join(', ') + ', ';
            suggestionsBox.classList.add('hidden');
            hashtagsInput.focus();
        }

        // Ẩn khi click ngoài
        document.addEventListener('click', (e) => {
            if (!hashtagsInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });

        // === MEDIA UPLOAD & PREVIEW ===
        const dropZone = document.getElementById('drop-zone');
        const mediaInput = document.getElementById('media');
        const preview = document.getElementById('preview');
        let filesArray = [];

        dropZone.addEventListener('click', () => mediaInput.click());

        ['dragover', 'dragenter'].forEach(e => dropZone.addEventListener(e, ev => {
            ev.preventDefault();
            dropZone.classList.add('bg-pink-100/50', 'border-pink-600');
        }));

        ['dragleave', 'dragend', 'drop'].forEach(e => dropZone.addEventListener(e, ev => {
            ev.preventDefault();
            dropZone.classList.remove('bg-pink-100/50', 'border-pink-600');
        }));

        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            handleFiles(e.dataTransfer.files);
        });

        mediaInput.addEventListener('change', () => handleFiles(mediaInput.files));

        function handleFiles(files) {
            const newFiles = Array.from(files).filter(file => 
                file.type.startsWith('image/') || file.type.startsWith('video/')
            );

            if (filesArray.length + newFiles.length > 10) {
                alert('Tối đa chỉ được upload 10 file thôi nha!');
                return;
            }

            filesArray.push(...newFiles);
            renderPreview();
        }

        function renderPreview() {
            preview.innerHTML = '';
            filesArray.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'relative group';

                if (file.type.startsWith('image/')) {
                    div.innerHTML = `<img src="${URL.createObjectURL(file)}" class="h-32 w-32 object-cover rounded-xl shadow-lg">`;
                } else {
                    div.innerHTML = `
                        <video src="${URL.createObjectURL(file)}" controls class="h-32 w-32 object-cover rounded-xl shadow-lg"></video>
                        <div class="absolute inset-0 bg-black/30 rounded-xl flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    `;
                }

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.innerHTML = '×';
                removeBtn.className = 'absolute -top-3 -right-3 bg-red-600 text-white w-9 h-9 rounded-full text-2xl font-bold opacity-0 group-hover:opacity-100 transition hover:bg-red-700 shadow-lg';
                removeBtn.onclick = () => {
                    filesArray.splice(index, 1);
                    renderPreview();
                };

                div.appendChild(removeBtn);
                preview.appendChild(div);
            });
        }

        // Khi submit: gán lại file vào input thật
        document.getElementById('post-form').addEventListener('submit', () => {
            const dt = new DataTransfer();
            filesArray.forEach(file => dt.items.add(file));
            mediaInput.files = dt.files;
        });
    </script>
</x-app-layout>

{{-- CSS Glow đẹp hơn --}}
<style>
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .glow-text {
        text-shadow: 0 0 10px #fd1d1d, 0 0 20px #e1306c, 0 0 30px #833ab4;
    }
    .btn-glow {
        background: linear-gradient(45deg, #fd1d1d, #e1306c, #833ab4, #5851db);
        position: relative;
        overflow: hidden;
    }
    .btn-glow:before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: rotate(45deg);
        transition: all 0.6s;
    }
    .btn-glow:hover:before {
        animation: shine 0.8s ease-in-out;
    }
    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
</style>