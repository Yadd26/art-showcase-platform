@extends('layouts.guest')

@section('title', 'Discover Amazing Artworks')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6">Discover & Share Amazing Artworks</h1>
            <p class="text-xl text-gray-200 mb-8 max-w-3xl mx-auto">
                Platform showcase untuk kreator seni digital. Upload karya, ikuti challenge, dan dapatkan inspirasi dari komunitas kreatif.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('guest.artworks.index') }}" class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 transition">
                    Explore Artworks
                </a>
                @guest
                <a href="{{ route('register') }}" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                    Join as Creator
                </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" name="search" placeholder="Search artworks or artists..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
            </div>
            
            <!-- Category Filter -->
            <div class="w-full md:w-64">
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->icon }} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                Search
            </button>
        </form>
    </div>
</div>

<!-- Featured Artworks -->
@if($featuredArtworks->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-blue-900">Featured Artworks</h2>
        <a href="{{ route('guest.artworks.index') }}" class="text-blue-900 hover:text-yellow-500 font-semibold">
            View All →
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredArtworks as $artwork)
            <x-artwork-card :artwork="$artwork" />
        @endforeach
    </div>
</section>
@endif

<!-- Active Challenges -->
@if($activeChallenges->count() > 0)
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900">Active Challenges</h2>
            <a href="{{ route('guest.challenges.index') }}" class="text-blue-900 hover:text-yellow-500 font-semibold">
                View All →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($activeChallenges as $challenge)
                <x-challenge-card :challenge="$challenge" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Popular Artworks -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-blue-900 mb-8">Popular Artworks</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($popularArtworks as $artwork)
            <x-artwork-card :artwork="$artwork" :compact="true" />
        @endforeach
    </div>
</section>

<!-- Recent Artworks -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-blue-900 mb-8">Recent Artworks</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($recentArtworks as $artwork)
                <x-artwork-card :artwork="$artwork" :compact="true" />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('guest.artworks.index') }}" class="bg-blue-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-800 transition inline-block">
                Browse All Artworks
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
@guest
<section class="bg-gradient-to-r from-yellow-400 to-yellow-300 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-blue-900 mb-4">Ready to showcase your art?</h2>
        <p class="text-xl text-blue-800 mb-8">
            Join our community of talented creators and start sharing your artworks today!
        </p>
        <a href="{{ route('register') }}" class="bg-blue-900 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition inline-block text-lg">
            Create Free Account
        </a>
    </div>
</section>
@endguest
@endsection