<x-guest-layout>
<div class="relative min-h-screen bg-gradient-to-br from-purple-400 via-pink-300 to-yellow-200 overflow-hidden">

    <!-- Particle background -->
    <div id="particles" class="absolute inset-0 z-0 pointer-events-none"></div>

    <!-- Title -->
    <div class="relative z-10 text-center pt-16">
        <h1 class="text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-pink-400 via-purple-400 to-yellow-300 text-transparent bg-clip-text drop-shadow-lg">
            Skincare Forum
        </h1>
    </div>

    <!-- Form card -->
    <div class="relative z-10 flex items-center justify-center mt-12 px-4">
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl w-full max-w-md p-8 space-y-6">

            <!-- Register title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 drop-shadow-md">Đăng ký</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4 relative z-10">
                @csrf

                <!-- Name -->
                <div>
                    <x-text-input id="name" 
                        class="block mt-1 w-full bg-white text-gray-900 placeholder-gray-400 rounded-xl border border-gray-300 px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition duration-300 text-sm"
                        type="text" name="name" :value="old('name')" placeholder="Nhập tên..." required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Email -->
                <div>
                    <x-text-input id="email" 
                        class="block mt-1 w-full bg-white text-gray-900 placeholder-gray-400 rounded-xl border border-gray-300 px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition duration-300 text-sm"
                        type="email" name="email" :value="old('email')" placeholder="Nhập email..." required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-text-input id="password" 
                        class="block mt-1 w-full bg-white text-gray-900 placeholder-gray-400 rounded-xl border border-gray-300 px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition duration-300 text-sm"
                        type="password" name="password" placeholder="Mật khẩu..." required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-text-input id="password_confirmation" 
                        class="block mt-1 w-full bg-white text-gray-900 placeholder-gray-400 rounded-xl border border-gray-300 px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition duration-300 text-sm"
                        type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu..." required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Buttons + login link -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-2">
                    <!-- Register button -->
                    <button type="submit" 
                        class="w-full sm:w-auto bg-gradient-to-r from-pink-400 via-purple-400 to-yellow-300 
                               text-white font-bold px-5 py-2 rounded-full shadow-lg hover:shadow-xl 
                               transform hover:-translate-y-0.5 transition duration-300 text-sm">
                        Register
                    </button>

                    <!-- Already registered link -->
                    <a href="{{ route('login') }}" class="text-gray-800 underline hover:text-pink-500 text-sm text-center sm:text-left">
                        Already registered?
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
    particlesJS("particles", {
        "particles": {
            "number": {"value": 30, "density": {"enable": true, "value_area": 700}},
            "color": {"value": ["#ff9a9e","#fad0c4","#fbc2eb","#a6c1ee"]},
            "shape": {"type": "circle"},
            "opacity": {"value": 0.5, "random": true},
            "size": {"value": 6, "random": true},
            "line_linked": {"enable": false},
            "move": {"enable": true, "speed": 1.5, "direction": "top", "random": true, "straight": false}
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {"onhover": {"enable": true, "mode": "repulse"}}
        },
        "retina_detect": true
    });
    </script>
</div>
</x-guest-layout>
