<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skincare Forum') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
/* --- Instagram Gradient Background Animation --- */
@keyframes instaFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-animated {
    background: linear-gradient(
        260deg,
        #405DE6,
        #5851DB,
        #833AB4,
        #C13584,
        #E1306C,
        #FD1D1D
    );
    background-size: 500% 500%;
    animation: instaFlow 14s ease infinite;
}

/* Glass effect */
.glass {
    background: rgba(255, 255, 255, 0.50);
    backdrop-filter: blur(14px);
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.10);
}

/* Navigation hover */
.nav-hover {
    transition: 0.25s ease;
}
.nav-hover:hover {
    color: #ff2975;
    transform: translateY(-2px);
}

/* Search input */
input[type="text"] {
    background: #ffffffcc;
}

/* Buttons */
button {
    transition: 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* Instagram-style pink–purple button */
.btn-gradient {
    background: linear-gradient(to right, #833ab4, #fd1d1d);
    color: white;
    font-weight: 600;
}
.btn-gradient:hover {
    background: linear-gradient(to right, #fd1d1d, #833ab4);
    transform: translateY(-2px);
}
/* Insta Neon Glow (cho header, card, container) */
.glow-box {
    border-radius: 1rem;
    position: relative;
    overflow: hidden;
}

.glow-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        #fd1d1d,
        #e1306c,
        #c13584,
        #833ab4,
        #5851db
    );
    opacity: 0.35;
    filter: blur(25px);
    z-index: -1;
}

/* Glow on hover */
.hover-glow {
    transition: all 0.3s ease;
}
.hover-glow:hover {
    box-shadow: 0 0 18px rgba(253, 29, 29, 0.5),
                0 0 25px rgba(131, 58, 180, 0.5);
    transform: translateY(-3px);
}

/* Insta icon hover */
.icon-hover:hover {
    color: #fd1d1d !important;
    text-shadow: 0 0 10px #fd1d1d;
}

/* Extra Glow Button */
.btn-glow {
    background: linear-gradient(45deg, #fd1d1d, #833ab4);
    color: white;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
    transition: 0.3s ease;
}
.btn-glow:hover {
    box-shadow: 0 0 15px #fd1d1d, 0 0 30px #833ab4;
    transform: translateY(-3px);
}
</style>
</head>

<body class="font-sans antialiased text-gray-800">

    <!-- FULL BACKGROUND -->
    <div class="min-h-screen bg-animated">

        {{-- HEADER — NAVIGATION --}}
        <header class="backdrop-blur-xl bg-white/10 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

               <nav class="flex items-center justify-between w-full">

    <!-- Logo -->
    <a href="{{ route('forum.index') }}" class="text-2xl font-bold text-white drop-shadow">
        Skincare Forum
    </a>

    <!-- Desktop Menu -->
    <div class="hidden sm:flex items-center space-x-4">

        <a href="{{ route('forum.index') }}" 
           class="nav-hover transition {{ request()->routeIs('forum.index') ? 'underline' : '' }} hover:text-pink-400">
            Diễn đàn
        </a>

        @auth
            <a href="{{ route('forum.create') }}" 
               class="nav-hover transition {{ request()->routeIs('forum.create') ? 'underline' : '' }} hover:text-pink-400">
                Tạo bài viết
            </a>
        @endauth
           @auth
<a href="{{ route('chat.index') }}" class="nav-hover text-white font-semibold hover:text-pink-400">
    Chat riêng
</a>
@endauth


        <!-- Search -->
        <form action="{{ route('forum.index') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Tìm kiếm..." 
                   value="{{ request('search') }}"
                   class="px-3 py-1 rounded-l-lg border-none bg-white/70 text-gray-800 focus:ring-2 focus:ring-pink-400">
            <button type="submit" 
                    class="px-3 py-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-r-lg hover:from-purple-600 hover:to-pink-500 transition transform hover:scale-105">
                🔍
            </button>
        </form>

        <!-- Auth User -->
        @auth
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full hover:scale-105 transition transform text-white font-semibold shadow-lg hover:shadow-pink-400/50">
                {{ Auth::user()->name }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-48 bg-white/70 backdrop-blur-md rounded-xl shadow-lg py-2 z-50 text-gray-800">
                <x-dropdown-link :href="route('profile.edit')" class="hover:bg-pink-100 transition px-4 py-2 rounded-lg">
                    Profile
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left hover:bg-pink-100 transition px-4 py-2 rounded-lg">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
        @else
            <a href="{{ route('login') }}" 
               class="btn-glow px-4 py-2 rounded-full text-white font-semibold shadow-lg hover:shadow-pink-400/50 transition transform hover:scale-105">
               Login
            </a>
            <a href="{{ route('register') }}" 
               class="btn-glow px-4 py-2 rounded-full text-white font-semibold shadow-lg hover:shadow-purple-400/50 transition transform hover:scale-105">
               Register
            </a>
        @endauth
    </div>

    <!-- Mobile Hamburger -->
    <div class="sm:hidden" x-data="{ open: false }">
        <button @click="open = !open" class="text-white text-3xl">☰</button>

        <!-- Mobile Menu -->
        <div x-show="open" @click.away="open = false" class="absolute top-full left-0 w-full bg-white/20 backdrop-blur-lg shadow-lg flex flex-col p-4 space-y-2 z-40">
            
            <a href="{{ route('forum.index') }}" class="nav-hover text-white font-semibold hover:text-pink-400">Diễn đàn</a>
            @auth
                <a href="{{ route('forum.create') }}" class="nav-hover text-white font-semibold hover:text-pink-400">Tạo bài viết</a>
            @endauth

            <!-- Search -->
            <form action="{{ route('forum.index') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Tìm kiếm..." 
                       value="{{ request('search') }}"
                       class="px-3 py-1 rounded-l-lg border-none bg-white/70 text-gray-800 w-full">
                <button type="submit" class="px-3 py-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-r-lg hover:from-purple-600 hover:to-pink-500 transition transform hover:scale-105">
                    🔍
                </button>
            </form>

            <!-- Auth Buttons -->
            @auth
                <a href="{{ route('profile.edit') }}" class="btn-glow text-center py-2 w-full">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-glow text-center py-2 w-full">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-glow text-center py-2 w-full">Login</a>
                <a href="{{ route('register') }}" class="btn-glow text-center py-2 w-full">Register</a>
            @endauth
        </div>
    </div>

</nav>
                <!-- Mobile Button -->
                <div class="sm:hidden">
                    <button @click="open = !open" class="text-white text-3xl">☰</button>
                </div>
            </div>
        </header>


        {{-- PAGE CONTENT --}}
        <main class="max-w-6xl mx-auto py-10 px-6">
            <div class="glass rounded-2xl p-6 shadow-xl">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Diễn đàn Mỹ phẩm & Sắc đẹp
        </h2>
                {{ $slot }}
            </div>
        </main>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
