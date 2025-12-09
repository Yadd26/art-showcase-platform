@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center px-4 py-3 bg-blue-800 rounded-lg font-medium">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>
    
    <a href="{{ route('admin.users.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        User Management
    </a>
    
    <a href="{{ route('admin.categories.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
        </svg>
        Categories
    </a>
    
    <a href="{{ route('admin.moderation.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        Moderation
        @if($stats['pending_reports'] > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                {{ $stats['pending_reports'] }}
            </span>
        @endif
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-600">Members: {{ $stats['total_members'] }}</span>
                <span class="mx-2">•</span>
                <span class="text-gray-600">Curators: {{ $stats['total_curators'] }}</span>
            </div>
        </div>

        <!-- Total Artworks -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Artworks</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_artworks'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Challenges -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Challenges</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_challenges'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Reports</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_reports'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            @if($stats['pending_reports'] > 0)
                <a href="{{ route('admin.moderation.index') }}" class="mt-4 text-sm text-red-600 hover:text-red-700 font-medium">
                    Review Reports →
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Curators -->
        @if($pendingCurators->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Pending Curator Approvals</h2>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $pendingCurators->count() }}
                    </span>
                </div>
                
                <div class="space-y-3">
                    @foreach($pendingCurators as $curator)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-900 font-bold">{{ substr($curator->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $curator->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $curator->email }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.users.approve', $curator) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.reject', $curator) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block text-blue-900 hover:text-yellow-500 font-medium text-sm">
                    View All Users →
                </a>
            </div>
        @endif

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Users</h2>
            
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-900 font-bold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ ucfirst($user->role->value) }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Artworks -->
    @if($recentArtworks->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Artworks</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($recentArtworks as $artwork)
                    <a href="{{ route('guest.artworks.show', $artwork) }}" class="group">
                        <img src="{{ Storage::url($artwork->image_path) }}" 
                             alt="{{ $artwork->title }}"
                             class="w-full h-32 object-cover rounded-lg group-hover:opacity-75 transition">
                        <p class="mt-2 text-sm font-medium text-gray-800 truncate">{{ $artwork->title }}</p>
                        <p class="text-xs text-gray-600">by {{ $artwork->user->display_name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection