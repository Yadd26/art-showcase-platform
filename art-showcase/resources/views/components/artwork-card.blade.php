@props(['artwork', 'compact' => false])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 group">
    <!-- Image -->
    <a href="{{ route('guest.artworks.show', $artwork) }}" class="block relative overflow-hidden">
        <img src="{{ Storage::url($artwork->image_path) }}" 
             alt="{{ $artwork->title }}"
             class="w-full {{ $compact ? 'h-48' : 'h-64' }} object-cover group-hover:scale-110 transition duration-300">
        
        <!-- Overlay on hover -->
        <div class="absolute inset-0 bg-blue-900 bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
            <span class="text-white font-semibold opacity-0 group-hover:opacity-100 transition duration-300">
                View Details →
            </span>
        </div>
    </a>
    
    <!-- Content -->
    <div class="p-4">
        <!-- Title -->
        <h3 class="font-bold text-lg text-gray-800 mb-2 truncate">
            <a href="{{ route('guest.artworks.show', $artwork) }}" class="hover:text-blue-900">
                {{ $artwork->title }}
            </a>
        </h3>
        
        <!-- Category -->
        <div class="flex items-center mb-3">
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                {{ $artwork->category->icon }} {{ $artwork->category->name }}
            </span>
        </div>
        
        @if(!$compact)
        <!-- Description (only if not compact) -->
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
            {{ Str::limit($artwork->description, 100) }}
        </p>
        @endif
        
        <!-- Creator -->
        <div class="flex items-center mb-3">
            <a href="{{ route('guest.profile', $artwork->user) }}" class="flex items-center hover:text-blue-900">
                @if($artwork->user->profile_photo)
                    <img src="{{ Storage::url($artwork->user->profile_photo) }}" 
                         alt="{{ $artwork->user->display_name }}"
                         class="w-6 h-6 rounded-full object-cover mr-2">
                @else
                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center mr-2">
                        <span class="text-xs text-blue-900 font-bold">{{ substr($artwork->user->name, 0, 1) }}</span>
                    </div>
                @endif
                <span class="text-sm text-gray-700">{{ $artwork->user->display_name }}</span>
            </a>
        </div>
        
        <!-- Stats -->
        <div class="flex items-center justify-between text-sm text-gray-500">
            <div class="flex space-x-4">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                    </svg>
                    {{ $artwork->likes_count }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                    </svg>
                    {{ $artwork->comments_count }}
                </span>
            </div>
            <span class="text-xs text-gray-400">
                {{ $artwork->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</div>