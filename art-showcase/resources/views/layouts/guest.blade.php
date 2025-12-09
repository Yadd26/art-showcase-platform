<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Art Showcase') }} - @yield('title', 'Discover Amazing Artworks')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom color palette */
        :root {
            --navy: #1e3a8a;
            --gold: #fbbf24;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-blue-900 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🎨</span>
                        </div>
                        <span class="text-xl font-bold text-white">ArtShowcase</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex ml-10 space-x-8">
                        <a href="{{ route('home') }}" class="text-white hover:text-yellow-400 px-3 py-2 rounded-md text-sm font-medium transition">
                            Home
                        </a>
                        <a href="{{ route('guest.artworks.index') }}" class="text-white hover:text-yellow-400 px-3 py-2 rounded-md text-sm font-medium transition">
                            Artworks
                        </a>
                        <a href="{{ route('guest.challenges.index') }}" class="text-white hover:text-yellow-400 px-3 py-2 rounded-md text-sm font-medium transition">
                            Challenges
                        </a>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Authenticated User -->
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-2 text-white hover:text-yellow-400 transition">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <span class="text-blue-900 font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="font-medium">{{ auth()->user()->display_name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-yellow-50 transition">
                                        Admin Dashboard
                                    </a>
                                @elseif(auth()->user()->isCurator())
                                    <a href="{{ route('curator.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-yellow-50 transition">
                                        Curator Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-yellow-50 transition">
                                        My Dashboard
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-yellow-50 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest User -->
                        <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 px-4 py-2 rounded-md text-sm font-medium transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-900 hover:bg-yellow-300 px-4 py-2 rounded-md text-sm font-bold transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-blue-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-yellow-400 mb-4">ArtShowcase</h3>
                    <p class="text-gray-300">Platform showcase karya seni digital untuk kreator dan art enthusiasts.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('guest.artworks.index') }}" class="text-gray-300 hover:text-yellow-400 transition">Browse Artworks</a></li>
                        <li><a href="{{ route('guest.challenges.index') }}" class="text-gray-300 hover:text-yellow-400 transition">View Challenges</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-yellow-400 transition">Join as Creator</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect</h4>
                    <p class="text-gray-300">© {{ date('Y') }} ArtShowcase. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (!e.target.closest('button') && dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>