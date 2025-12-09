@extends('layouts.app')

@section('title', $artwork->title)
@section('page-title', 'Artwork Details')

@section('sidebar')
    <a href="{{ route('member.dashboard') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>
    
    <a href="{{ route('member.artworks.index') }}" 
       class="flex items-center px-4 py-3 bg-blue-800 rounded-lg font-medium">
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
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('member.artworks.index') }}" 
           class="inline-flex items-center text-blue-900 hover:text-yellow-500 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Artworks
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Image Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <img src="{{ Storage::url($artwork->image_path) }}" 
                     alt="{{ $artwork->title }}"
                     class="w-full h-auto object-contain max-h-[600px] bg-gray-100">
            </div>

            <!-- Artwork Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $artwork->title }}</h1>
                
                <!-- Category -->
                <div class="flex items-center mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $artwork->category->icon }} {{ $artwork->category->name }}
                    </span>
                </div>

                <!-- Description -->
                @if($artwork->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $artwork->description }}</p>
                    </div>
                @endif

                <!-- Tags -->
                @if($artwork->tags)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $artwork->tags) as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-1">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $artwork->likes_count }}</p>
                        <p class="text-sm text-gray-600">Likes</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-1">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $artwork->comments_count }}</p>
                        <p class="text-sm text-gray-600">Comments</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-1">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $artwork->favorites_count }}</p>
                        <p class="text-sm text-gray-600">Favorites</p>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            @if($artwork->comments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        Comments ({{ $artwork->comments_count }})
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($artwork->comments as $comment)
                            <div class="flex space-x-3 pb-4 border-b border-gray-200 last:border-0 last:pb-0">
                                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-900 font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-gray-800">{{ $comment->user->display_name }}</p>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <!-- View Public Page -->
                    <a href="{{ route('guest.artworks.show', $artwork) }}" 
                       target="_blank"
                       class="w-full bg-blue-900 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-800 transition text-center block">
                        View Public Page
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('member.artworks.edit', $artwork) }}" 
                       class="w-full bg-yellow-400 text-blue-900 px-4 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition text-center block">
                        Edit Artwork
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('member.artworks.destroy', $artwork) }}" 
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this artwork? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-600 transition">
                            Delete Artwork
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Information</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600 mb-1">Uploaded</p>
                        <p class="font-semibold text-gray-800">{{ $artwork->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
                    </div>

                    @if($artwork->updated_at != $artwork->created_at)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-gray-600 mb-1">Last Updated</p>
                            <p class="font-semibold text-gray-800">{{ $artwork->updated_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $artwork->updated_at->diffForHumans() }}</p>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-gray-600 mb-1">Category</p>
                        <p class="font-semibold text-gray-800">{{ $artwork->category->icon }} {{ $artwork->category->name }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-gray-600 mb-1">Visibility</p>
                        <p class="font-semibold text-gray-800">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-green-100 text-green-800">
                                Public
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection