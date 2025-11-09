<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Diễn đàn')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<!-- Top navigation -->
<header class="bg-yellow-500 text-white shadow">
    <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
        <a href="{{ route('threads.index') }}" class="text-2xl font-bold">Diễn đàn</a>
        <nav class="space-x-4">
            @auth
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Đăng nhập</a>
                <a href="{{ route('register') }}" class="hover:underline">Đăng ký</a>
            @endauth
        </nav>
    </div>
</header>

<!-- Main content -->
<div class="max-w-7xl mx-auto lg:flex py-6 px-4 space-x-6">

    <!-- Sidebar -->
    <aside class="hidden lg:block w-64 bg-white p-4 rounded-xl shadow space-y-6">
        <h3 class="font-bold text-yellow-800">Chủ đề nổi bật</h3>
        <ul class="space-y-2">
            <li><a href="#" class="hover:underline">Hot threads #1</a></li>
            <li><a href="#" class="hover:underline">Hot threads #2</a></li>
        </ul>

        <h3 class="font-bold text-yellow-800">Người dùng tích cực</h3>
        <ul class="space-y-2">
            @foreach($topUsers ?? [] as $user)
                <li>{{ $user->name }} ({{ $user->posts_count }} bình luận)</li>
            @endforeach
        </ul>
    </aside>

    <!-- Page content -->
    <main class="flex-1 space-y-6">
        @yield('content')
    </main>

</div>

<!-- Footer -->
<footer class="bg-yellow-100 text-yellow-800 p-4 mt-6 text-center">
    &copy; {{ date('Y') }} Diễn đàn Laravel
</footer>

</body>
</html>
