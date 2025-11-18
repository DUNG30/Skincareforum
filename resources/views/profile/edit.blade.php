<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Thông tin cá nhân & Cài đặt
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Thông báo thành công --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded shadow-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Thông báo lỗi --}}
        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-800 rounded shadow-sm border border-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Thẻ thông tin người dùng --}}
        <div class="bg-gradient-to-r from-purple-100 via-pink-100 to-yellow-100 shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row items-center md:items-start gap-6 border border-gray-200">
            {{-- Avatar --}}
            <div class="flex-shrink-0 relative group">
                <img id="avatar-preview" 
                     src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                     class="w-28 h-28 rounded-full object-cover border-2 border-gray-300 transition-transform duration-300 group-hover:scale-105" 
                     alt="Avatar của {{ $user->name }}">

                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="bg-black bg-opacity-50 text-white text-sm px-2 py-1 rounded cursor-pointer">Click để thay đổi</div>
                </div>
            </div>

            {{-- Thông tin cơ bản --}}
            <div class="flex-1 space-y-2">
                <h3 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-600">Email: {{ $user->email }}</p>
                <p class="text-gray-600">Ngày tham gia: {{ $user->created_at->format('d/m/Y') }}</p>
                <p class="text-gray-600">ID người dùng: {{ $user->id }}</p>
            </div>
        </div>

        {{-- Form cập nhật thông tin --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Cập nhật thông tin cá nhân</h3>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Avatar --}}
                <div class="mb-4">
                    <label for="avatar" class="block font-medium text-gray-700">Avatar</label>
                    <input id="avatar" name="avatar" type="file" accept="image/*" 
                        class="mt-1 block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0
                               file:text-sm file:font-semibold
                               file:bg-pink-200 file:text-pink-700
                               hover:file:bg-pink-300" />
                    @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Họ tên --}}
                <div class="mb-4">
                    <label for="name" class="block font-medium text-gray-700">Họ tên</label>
                    <input id="name" name="name" type="text" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition" 
                        value="{{ old('name', $user->name) }}" required autofocus />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition" 
                        value="{{ old('email', $user->email) }}" required />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Thay đổi mật khẩu --}}
                <div class="mb-4 border-t border-gray-200 pt-4 space-y-2">
                    <h4 class="font-semibold text-gray-700">Đổi mật khẩu</h4>

                    <div>
                        <label for="current_password" class="block font-medium text-gray-700">Mật khẩu hiện tại</label>
                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-gray-300 focus:border-gray-400 transition" />
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block font-medium text-gray-700">Mật khẩu mới</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-gray-300 focus:border-gray-400 transition" />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-gray-300 focus:border-gray-400 transition" />
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-pink-400 via-purple-400 to-blue-400 text-white rounded shadow hover:from-pink-500 hover:to-blue-500 font-medium transition-all duration-300">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview avatar khi chọn file
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');

        avatarInput.addEventListener('change', function(){
            const file = this.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(e){
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
