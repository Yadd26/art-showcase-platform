<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'ArtShowcase') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white hidden lg:block">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-blue-800">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🎨</span>
                        </div>
                        <span class="text-xl font-bold">ArtShowcase</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    @yield('sidebar')
                </nav>
                
                <!-- User Info -->
                <div class="p-4 border-t border-blue-800">
                    <div class="flex items-center space-x-3">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                                 alt="Profile" 
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                                <span class="text-blue-900 font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ auth()->user()->display_name }}</p>
                            <p class="text-xs text-blue-300 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-600 hover:text-blue-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Page Title -->
                    <h1 class="text-2xl font-bold text-blue-900">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- View Site -->
                        <a href="{{ route('home') }}" 
                           class="text-gray-600 hover:text-blue-900 transition"
                           target="_blank">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-600 hover:text-red-600 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            @if(session('info'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobileMenu" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 lg:hidden">
        <div class="bg-blue-900 w-64 h-full text-white">
            <div class="p-4 flex justify-between items-center border-b border-blue-800">
                <span class="text-xl font-bold">Menu</span>
                <button onclick="toggleMobileMenu()" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="p-4 space-y-2">
                @yield('sidebar')
            </nav>
        </div>
    </div>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>