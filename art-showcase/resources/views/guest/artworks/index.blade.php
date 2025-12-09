@extends('layouts.guest')

@section('title', 'Browse Artworks')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Explore Artworks</h1>
        <p class="text-xl text-gray-200">Discover amazing artworks from talented creators</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white shadow-md sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form action="{{ route('guest.artworks.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title, description, or artist..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
            </div>
            
            <!-- Category Filter -->
            <div class="w-full md:w-64">
                <select name="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->icon }} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Sort -->
            <div class="w-full md:w-48">
                <select name="sort" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                </select>
            </div>
            
            <button type="submit" 
                    class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition whitespace-nowrap">
                Apply Filters
            </button>
            
            @if(request()->hasAny(['search', 'category', 'sort']))
                <a href="{{ route('guest.artworks.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition whitespace-nowrap">
                    Clear
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Results Count -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <p class="text-gray-600">
        Showing <span class="font-semibold">{{ $artworks->count() }}</span> of 
        <span class="font-semibold">{{ $artworks->total() }}</span> artworks
        @if(request('search'))
            for "<span class="font-semibold">{{ request('search') }}</span>"
        @endif
    </p>
</div>

<!-- Artworks Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    @if($artworks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($artworks as $artwork)
                <x-artwork-card :artwork="$artwork" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $artworks->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No artworks found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
            <a href="{{ route('guest.artworks.index') }}" 
               class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                Clear Filters
            </a>
        </div>
    @endif
</section>

<!-- Categories Showcase -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-blue-900 mb-8 text-center">Browse by Category</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('guest.artworks.index', ['category' => $category->id]) }}" 
                   class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition group">
                    <div class="text-4xl mb-2">{{ $category->icon }}</div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-900 transition">
                        {{ $category->name }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $category->artworks_count ?? 0 }} artworks</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
@guest
<section class="bg-gradient-to-r from-yellow-400 to-yellow-300 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-blue-900 mb-4">Join Our Creative Community</h2>
        <p class="text-xl text-blue-800 mb-8">
            Upload your artworks, participate in challenges, and get inspired!
        </p>
        <a href="{{ route('register') }}" 
           class="bg-blue-900 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition inline-block text-lg">
            Sign Up Free
        </a>
    </div>
</section>
@endguest
@endsection