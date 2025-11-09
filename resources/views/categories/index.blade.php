<x-app-layout>
    <x-slot name="header">
        📁 Categories
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->id) }}"
               class="block p-5 rounded-xl shadow hover:shadow-lg hover-glow bg-white transition transform hover:scale-[1.02]">
                <h3 class="text-lg font-semibold text-pink-600">{{ $category->name }}</h3>
                <p class="text-gray-700 mt-1">Xem tất cả chủ đề trong danh mục này.</p>
            </a>
        @empty
            <p class="text-gray-400 italic col-span-full">Chưa có danh mục nào.</p>
        @endforelse
    </div>
</x-app-layout>
