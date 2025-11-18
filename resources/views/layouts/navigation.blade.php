<nav x-data="{ open: false }" class="shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <a href="{{ route('forum.index') }}" class="text-2xl font-bold text-pink-600">
                Skincare Forum
            </a>

            <!-- Desktop Nav + Search + Create Post -->
            <div class="hidden sm:flex sm:items-center space-x-4 relative"
                 x-data="{ query: '', results: [], openSearch: false }">

                <!-- Diễn đàn link -->
                <x-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.index')" 
                    class="text-gray-700 font-semibold hover:text-pink-500 transition-colors duration-300">
                    Diễn đàn
                </x-nav-link>

                <!-- Search Form -->
                <div class="relative w-64">
                    <input type="text"
                        x-model="query"
                        @input.debounce.300ms="
                            if(query.length > 0){
                                fetch('{{ route('forum.search') }}?q='+query)
                                    .then(res => res.json())
                                    .then(data => { results = data; openSearch = true; })
                            } else { openSearch = false; results = []; }"
                        placeholder="Tìm kiếm bài viết..."
                        class="w-full px-3 py-2 rounded-l-full border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 bg-gradient-to-r from-pink-50 via-purple-50 to-indigo-50 text-gray-800 placeholder-gray-400 shadow-sm transition"
                    >
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-pink-300 text-white rounded-r-full hover:bg-pink-400 transition shadow">
                        🔍
                    </button>

                    <!-- Autocomplete dropdown -->
                    <div x-show="openSearch && results.length > 0" @click.away="openSearch = false"
                        class="absolute z-50 mt-1 w-full bg-white border border-pink-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <template x-for="item in results" :key="item.id">
                            <a :href="'/post/'+item.slug" class="block px-4 py-2 hover:bg-pink-50 transition">
                                <span x-text="item.title"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Tạo bài viết -->
                @auth
                <x-nav-link :href="route('forum.create')" :active="request()->routeIs('forum.create')"
                    class="text-gray-700 font-semibold hover:text-pink-500 transition-colors duration-300 bg-gradient-to-r from-pink-100 via-purple-100 to-indigo-100 px-4 py-2 rounded-full shadow-sm hover:shadow-md">
                    Tạo bài viết
                </x-nav-link>
                @endauth
            </div>

            <!-- User Dropdown / Login -->
            <div class="hidden sm:flex sm:items-center space-x-4">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-pink-50 transition shadow-sm">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:text-pink-500 transition">Log Out</button>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

                @guest
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-gray-700 font-semibold hover:text-pink-500 transition">
                    Login
                </x-nav-link>
                <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-gray-700 font-semibold hover:text-pink-500 transition">
                    Register
                </x-nav-link>
                @endguest
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-gray-700 hover:text-pink-500 hover:bg-white transition shadow-sm">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gradient-to-r from-pink-200 via-purple-200 to-indigo-200 shadow-lg">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.index')" class="text-gray-700 font-semibold hover:text-pink-500 transition">
                Diễn đàn
            </x-responsive-nav-link>

            <!-- Mobile search -->
            <form action="{{ route('forum.index') }}" method="GET" class="mt-2 flex">
                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}"
                    class="flex-1 px-3 py-1 rounded-l-full border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 bg-white text-gray-800 placeholder-gray-400">
                <button type="submit" class="px-3 py-1 bg-pink-300 text-white rounded-r-full hover:bg-pink-400 transition">
                    🔍
                </button>
            </form>

            @auth
            <x-responsive-nav-link :href="route('forum.create')" :active="request()->routeIs('forum.create')" class="text-gray-700 font-semibold hover:text-pink-500 transition">
                Tạo bài viết
            </x-responsive-nav-link>
            @endauth
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</nav>
