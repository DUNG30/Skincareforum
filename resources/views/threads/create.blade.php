<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-yellow-600 leading-tight">
            Tạo chủ đề mới ✨
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if ($errors->any())
            <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl shadow">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-yellow-50 p-6 rounded-xl shadow hover:shadow-lg transition space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-1">Tiêu đề</label>
                <input type="text" name="title" id="title"
                       class="w-full border border-yellow-200 rounded-xl px-4 py-2 focus:ring focus:ring-yellow-100 focus:border-yellow-300 transition"
                       placeholder="Nhập tiêu đề hấp dẫn..." required>
            </div>

            <div>
                <label for="body" class="block text-gray-700 font-semibold mb-1">Nội dung</label>
                <textarea name="body" id="body" rows="6"
                          class="w-full border border-yellow-200 rounded-xl px-4 py-2 focus:ring focus:ring-yellow-100 focus:border-yellow-300 transition"
                          placeholder="Viết nội dung chủ đề..." required></textarea>
            </div>

            <!-- Upload ảnh -->
            <div x-data="{ files: [] }" class="space-y-2">
                <label class="block text-gray-700 font-semibold mb-1">Ảnh đính kèm</label>
                <div @dragover.prevent @drop.prevent="Array.from($event.dataTransfer.files).forEach(f => files.push(f))"
                     class="w-full min-h-[120px] border-2 border-dashed border-yellow-300 rounded-xl flex flex-col items-center justify-center cursor-pointer bg-yellow-50 hover:bg-yellow-100 transition"
                     @click="$refs.fileInput.click()">
                    <p class="text-yellow-600 font-medium">Kéo thả ảnh vào đây hoặc nhấp để chọn</p>
                    <input type="file" name="images[]" multiple accept="image/*" class="hidden" x-ref="fileInput"
                           @change="Array.from($event.target.files).forEach(f => files.push(f))">
                </div>

                <template x-for="(file, index) in files" :key="index">
                    <div class="flex items-center space-x-2 bg-white p-2 rounded-xl shadow">
                        <img :src="URL.createObjectURL(file)" class="w-16 h-16 object-cover rounded" alt="">
                        <span x-text="file.name" class="text-gray-700"></span>
                        <button type="button" @click="files.splice(index,1)"
                                class="ml-auto text-red-500 font-bold hover:text-red-700 transition">&times;</button>
                    </div>
                </template>
            </div>

            <div>
                <label for="hashtags" class="block text-gray-700 font-semibold mb-1">Hashtags</label>
                <input type="text" name="hashtags" id="hashtags"
                       class="w-full border border-yellow-200 rounded-xl px-4 py-2 focus:ring focus:ring-yellow-100 focus:border-yellow-300 transition"
                       placeholder="#hashtag1 #hashtag2">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-yellow-500 text-white px-6 py-2 rounded-xl shadow hover:bg-yellow-600 transition font-semibold">
                    Tạo chủ đề
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
