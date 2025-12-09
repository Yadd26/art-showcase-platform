@extends('layouts.app')

@section('title', 'Member Dashboard')
@section('page-title', 'My Dashboard')

@section('sidebar')
    <a href="{{ route('member.dashboard') }}" 
       class="flex items-center px-4 py-3 bg-blue-800 rounded-lg font-medium">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>
    
    <a href="{{ route('member.artworks.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        My Artworks
    </a>
    
    <a href="{{ route('member.favorites') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        Favorites
    </a>
    
    <a href="{{ route('member.submissions.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
        </svg>
        My Submissions
    </a>
    
    <a href="{{ route('member.profile.edit') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profile
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Artworks -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Artworks</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $stats['total_artworks'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Likes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Likes</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['total_likes'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Comments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Comments</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_comments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Challenge Submissions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Submissions</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_submissions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Artworks & Submissions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Artworks -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-blue-900">Recent Artworks</h2>
                    <a href="{{ route('member.artworks.create') }}" 
                       class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition">
                        + Upload New
                    </a>
                </div>
                
                <div class="p-6">
                    @if($recentArtworks->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($recentArtworks as $artwork)
                                <a href="{{ route('member.artworks.show', $artwork) }}" 
                                   class="group block">
                                    <div class="relative overflow-hidden rounded-lg">
                                        <img src="{{ Storage::url($artwork->image_path) }}" 
                                             alt="{{ $artwork->title }}"
                                             class="w-full h-32 object-cover group-hover:scale-110 transition duration-300">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300"></div>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-800 truncate">{{ $artwork->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $artwork->category->name }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">No artworks yet</p>
                            <a href="{{ route('member.artworks.create') }}" 
                               class="mt-4 inline-block text-blue-900 hover:text-yellow-500 font-medium">
                                Upload your first artwork →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recent Submissions -->
        <div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-blue-900">Recent Submissions</h2>
                </div>
                
                <div class="p-6">
                    @if($recentSubmissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentSubmissions as $submission)
                                <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                    <a href="{{ route('guest.challenges.show', $submission->challenge) }}" 
                                       class="font-medium text-blue-900 hover:text-yellow-500">
                                        {{ $submission->challenge->title }}
                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">{{ $submission->artwork->title }}</p>
                                    @if($submission->isWinner())
                                        <span class="inline-block mt-2 text-xs font-bold text-yellow-700 bg-yellow-100 px-2 py-1 rounded">
                                            {{ $submission->getWinnerBadge() }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-600">No submissions yet</p>
                            <a href="{{ route('guest.challenges.index') }}" 
                               class="mt-2 inline-block text-blue-900 hover:text-yellow-500 font-medium text-sm">
                                Browse challenges →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection