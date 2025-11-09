<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Skincare Forum') }}</title>

    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
       body {
    /* Ombre kiểu vibrant pastel, chéo 135 độ */
    background: linear-gradient(135deg, #ffd1dc, #ffecd2, #fce7f0);
    color: #333;
}

/* Glassmorphism navbar / card */
.glass {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Chữ logo gradient */
.text-gradient {
    background: linear-gradient(90deg, #ff9a9e, #fad0c4, #fbc2eb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Transition mềm mại */
* {
    transition: all 0.25s ease-in-out;
}
    </style>
</head>
<body class="font-sans antialiased">

    {{-- Navbar --}}
    <nav class="glass shadow-lg fixed top-0 left-0 w-full z-50 border-b border-pink-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-gradient tracking-wide">🌸 Skincare Forum</a>
            <div class="hidden sm:flex space-x-6 font-medium">
                <a href="{{ route('threads.index') }}" class="hover:text-pink-400">Threads</a>
                <a href="{{ route('categories.index') }}" class="hover:text-pink-400">Categories</a>
            </div>
            <div class="relative flex items-center space-x-3">
                @auth
                   <span class="hidden sm:block font-medium">{{ Auth::user()->name }}</span>
<div class="group relative">
    <button class="rounded-full focus:outline-none">
        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
             alt="avatar"
             class="h-9 w-9 rounded-full border border-pink-200 hover-glow">
    </button>

    <!-- Dropdown menu -->
    <div class="hidden group-hover:flex flex-col absolute right-0 mt-16 w-44 rounded-xl menu-glow overflow-hidden z-50 dropdown-animation">
        
        <!-- Arrow -->
        <div class="absolute -top-2 right-5 w-4 h-4 bg-white rotate-45 border-l border-t border-pink-200"></div>

        <a href="{{ route('dashboard') }}" 
           class="block px-4 py-2 font-medium rounded-xl mb-1 hover:scale-105 transition transform text-center">
            📊 Dashboard
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="block px-4 py-2 rounded-xl mb-1 hover:scale-105 transition transform text-center">
            👤 Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full text-left px-4 py-2 rounded-xl hover:scale-105 transition transform text-center">
                🚪 Log Out
            </button>
        </form>
    </div>
</div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-pink-400">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-pink-400">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main content --}}
    <div class="max-w-7xl mx-auto pt-24 px-4 sm:px-6 lg:px-8 grid grid-cols-12 gap-8">
        {{-- Sidebar --}}
        <aside class="col-span-12 md:col-span-3 hidden md:block">
            <div class="bg-white rounded-2xl shadow-lg p-5 hover-glow">
                <h2 class="text-lg font-semibold mb-4">📁 Categories</h2>
                <ul class="space-y-2 text-gray-700">
                    @forelse($categories ?? [] as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->id) }}" 
                               class="block px-3 py-2 rounded-lg hover:bg-pink-100 hover:text-pink-600">
                                {{ $category->name }}
                            </a>
                        </li>
                    @empty
                        <li class="text-gray-400 italic">No categories yet.</li>
                    @endforelse
                </ul>
            </div>
        </aside>

        {{-- Main area --}}
        <main class="col-span-12 md:col-span-9">
            @isset($header)
                <div class="mb-6 border-b border-pink-200 pb-3">
                    <h1 class="text-3xl font-bold text-pink-600">{{ $header }}</h1>
                </div>
            @endisset
            <div class="space-y-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- Footer --}}
    <footer class="mt-16 py-8 border-t border-pink-100 text-center text-sm text-gray-500">
        © {{ date('Y') }} Skincare Forum · Built with 💖 by the Team
    </footer>
<style>
.menu-glow {
    position: relative;
    z-index: 0;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,192,203,0.4);
    transition: transform 0.2s ease, box-shadow 0.3s ease, opacity 0.3s ease;
}

.menu-glow::before {
    content: '';
    position: absolute;
    top: -5px; left: -5px; right: -5px; bottom: -5px;
    background: linear-gradient(270deg, #ff9a9e, #fad0c4, #fbc2eb, #a1c4fd);
    background-size: 600% 600%;
    border-radius: inherit;
    filter: blur(12px);
    opacity: 0;
    z-index: -1;
    animation: gradientGlow 6s ease infinite;
    transition: opacity 0.3s;
}

.menu-glow:hover::before {
    opacity: 0.5;
}

.menu-glow:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 15px 30px rgba(255,105,180,0.2);
}

/* Dropdown animation: xuất hiện từ dưới avatar */
.dropdown-animation {
    top: 100%; /* ngay dưới avatar */
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.group:hover .dropdown-animation {
    opacity: 1;
    transform: translateY(0);
}

@keyframes gradientGlow {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

/* Hover glow cho avatar */
.hover-glow {
    transition: box-shadow 0.3s ease, transform 0.2s ease;
}
.hover-glow:hover {
    box-shadow: 0 0 15px rgba(255,105,180,0.5);
    transform: scale(1.05);
}
</style>
</body>
</html>
