@props(['challenge'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
    <!-- Banner Image -->
    <a href="{{ route('guest.challenges.show', $challenge) }}" class="block relative overflow-hidden">
        @if($challenge->banner_image)
            <img src="{{ Storage::url($challenge->banner_image) }}" 
                 alt="{{ $challenge->title }}"
                 class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-r from-blue-900 to-blue-700 flex items-center justify-center">
                <span class="text-6xl">🏆</span>
            </div>
        @endif
        
        <!-- Status Badge -->
        <div class="absolute top-4 right-4">
            @if($challenge->isActive())
                <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                    Active
                </span>
            @elseif($challenge->hasEnded())
                <span class="px-3 py-1 bg-gray-500 text-white text-xs font-bold rounded-full">
                    Ended
                </span>
            @else
                <span class="px-3 py-1 bg-yellow-400 text-blue-900 text-xs font-bold rounded-full">
                    Upcoming
                </span>
            @endif
        </div>
    </a>
    
    <!-- Content -->
    <div class="p-4">
        <!-- Title -->
        <h3 class="font-bold text-lg text-gray-800 mb-2">
            <a href="{{ route('guest.challenges.show', $challenge) }}" class="hover:text-blue-900">
                {{ $challenge->title }}
            </a>
        </h3>
        
        <!-- Description -->
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
            {{ Str::limit($challenge->description, 100) }}
        </p>
        
        <!-- Curator -->
        <div class="flex items-center mb-3">
            <span class="text-xs text-gray-500">by</span>
            <a href="{{ route('guest.profile', $challenge->curator) }}" class="ml-1 text-sm text-blue-900 font-medium hover:underline">
                {{ $challenge->curator->display_name }}
            </a>
        </div>
        
        <!-- Prize (if exists) -->
        @if($challenge->prize)
        <div class="mb-3 p-2 bg-yellow-50 rounded border border-yellow-200">
            <p class="text-xs text-yellow-800 font-semibold">
                🎁 Prize: {{ $challenge->prize }}
            </p>
        </div>
        @endif
        
        <!-- Dates -->
        <div class="grid grid-cols-2 gap-2 mb-3 text-xs text-gray-600">
            <div>
                <span class="font-semibold">Start:</span>
                {{ $challenge->start_date->format('M d, Y') }}
            </div>
            <div>
                <span class="font-semibold">End:</span>
                {{ $challenge->end_date->format('M d, Y') }}
            </div>
        </div>
        
        <!-- Stats -->
        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
            <span class="text-sm text-gray-600">
                {{ $challenge->submissions_count ?? 0 }} Submissions
            </span>
            
            <a href="{{ route('guest.challenges.show', $challenge) }}" 
               class="text-sm text-blue-900 font-semibold hover:text-yellow-500 transition">
                View Details →
            </a>
        </div>
    </div>
</div>