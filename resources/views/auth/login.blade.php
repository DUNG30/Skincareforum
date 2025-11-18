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

            <!-- Login title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 drop-shadow-md">Đăng nhập</h2>

            <x-auth-session-status class="mb-4 text-gray-800 text-sm" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 relative z-10">
                @csrf

                <!-- Email -->
                <div>
                    <x-text-input id="email" 
                        class="block mt-1 w-full 
                               bg-white text-gray-900 
                               placeholder-gray-400
                               rounded-xl border border-gray-300
                               px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-pink-400 
                               focus:border-pink-400
                               transition duration-300 text-sm"
                        type="email" name="email" :value="old('email')" placeholder="Nhập email..." required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-text-input id="password" 
                        class="block mt-1 w-full 
                               bg-white text-gray-900 
                               placeholder-gray-400
                               rounded-xl border border-gray-300
                               px-4 py-2 shadow-sm
                               focus:ring-2 focus:ring-purple-400 
                               focus:border-purple-400
                               transition duration-300 text-sm"
                        type="password" name="password" placeholder="Mật khẩu..." required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center text-sm">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded text-pink-500">
                    <label for="remember_me" class="ml-2 text-gray-700">Remember me</label>
                </div>

                <!-- Login Button -->
                <div class="mt-2">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-pink-400 via-purple-400 to-yellow-300 text-white font-bold px-5 py-2 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300 text-sm">
                        Log in
                    </button>
                </div>

                <!-- Forgot Password + Register -->
                <div class="text-center mt-4 space-y-2">
                    @if (Route::has('password.request'))
                        <div>
                            <a href="{{ route('password.request') }}" 
                               class="text-gray-800 underline hover:text-pink-500 text-sm">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}" class="underline font-semibold text-pink-500 hover:text-purple-500 text-sm">
                            Đăng ký ngay
                        </a>
                    </div>
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
