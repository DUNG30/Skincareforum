<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gradient">Tạo chủ đề mới ✨</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        @if ($errors->any())
            <div class="p-4 bg-pink-50 text-pink-700 rounded-xl shadow-md">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data"
              class="glass p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 space-y-6">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title"
                       class="w-full border border-pink-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-pink-200 focus:border-pink-300 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Nội dung</label>
                <textarea name="body" rows="6"
                          class="w-full border border-pink-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-pink-200 focus:border-pink-300 transition-all duration-200"></textarea>
            </div>

            <div x-data="{ files: [] }" class="space-y-2">
                <label class="block mb-1 font-medium text-gray-700">Ảnh đính kèm</label>
                <div @dragover.prevent @drop.prevent="Array.from($event.dataTransfer.files).forEach(f => files.push(f))"
                     class="w-full min-h-[120px] border-2 border-dashed border-pink-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-pink-50 transition duration-200 transform hover:scale-105"
                     @click="$refs.fileInput.click()">
                    <p class="text-pink-600 font-medium">Kéo thả hoặc nhấp chọn ảnh</p>
                    <input type="file" name="images[]" multiple class="hidden" x-ref="fileInput" @change="Array.from($event.target.files).forEach(f => files.push(f))">
                </div>
                <template x-for="(file,index) in files" :key="index">
                    <div class="flex items-center space-x-2 bg-white p-2 rounded-xl shadow-md hover:shadow-lg transition duration-200">
                        <img :src="URL.createObjectURL(file)" class="w-16 h-16 object-cover rounded" alt="">
                        <span x-text="file.name" class="text-gray-700"></span>
                        <button type="button" @click="files.splice(index,1)" class="ml-auto text-red-500 font-bold hover:text-red-700">&times;</button>
                    </div>
                </template>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Hashtags</label>
                <input type="text" name="hashtags" placeholder="#tag1 #tag2"
                       class="w-full border border-pink-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-pink-200 focus:border-pink-300 transition-all duration-200">
            </div>

            <div class="flex justify-end relative">
                <button type="submit"
                        class="px-6 py-2 rounded-xl font-semibold text-white shadow-md 
                               bg-gradient-to-r from-pink-400 via-pink-300 to-yellow-200
                               hover:from-pink-500 hover:via-pink-400 hover:to-yellow-300
                               active:scale-95 active:shadow-inner
                               transition transform duration-200 glow-btn">
                    Tạo chủ đề
                </button>
            </div>
        </form>
    </div>

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
    </style>
</x-app-layout>
