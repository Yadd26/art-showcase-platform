@extends('layouts.guest')

@section('title', $challenge->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('guest.challenges.index') }}" 
           class="inline-flex items-center text-blue-900 hover:text-yellow-500 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Challenges
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (Left 2/3) -->
        <div class="lg:col-span-2">
            <!-- Challenge Banner -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                @if($challenge->banner_image)
                    <img src="{{ Storage::url($challenge->banner_image) }}" 
                         alt="{{ $challenge->title }}"
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gradient-to-r from-blue-900 to-blue-700 flex items-center justify-center">
                        <span class="text-9xl">🏆</span>
                    </div>
                @endif
            </div>

            <!-- Challenge Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $challenge->title }}</h1>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="ml-4">
                        @if($challenge->isActive())
                            <span class="px-4 py-2 bg-green-500 text-white font-bold rounded-full text-sm whitespace-nowrap">
                                ✓ Active
                            </span>
                        @elseif($challenge->hasEnded())
                            <span class="px-4 py-2 bg-gray-500 text-white font-bold rounded-full text-sm whitespace-nowrap">
                                ● Ended
                            </span>
                        @else
                            <span class="px-4 py-2 bg-yellow-400 text-blue-900 font-bold rounded-full text-sm whitespace-nowrap">
                                ⏰ Upcoming
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-600 whitespace-pre-line">{{ $challenge->description }}</p>
                </div>

                <!-- Rules -->
                @if($challenge->rules)
                    <div class="mb-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Rules</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-600 whitespace-pre-line">{{ $challenge->rules }}</p>
                        </div>
                    </div>
                @endif

                <!-- Prize -->
                @if($challenge->prize)
                    <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <span class="text-3xl mr-3">🎁</span>
                            <div>
                                <h3 class="font-bold text-yellow-800">Prize</h3>
                                <p class="text-yellow-700 text-lg font-semibold">{{ $challenge->prize }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Winners Section -->
            @if($winners->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏆</span>
                        Winners Announced!
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($winners as $winner)
                            <div class="relative group">
                                <!-- Winner Badge -->
                                <div class="absolute top-2 left-2 z-10">
                                    <span class="px-3 py-1 rounded-full text-white font-bold text-sm {{ $winner->winner_rank == 1 ? 'bg-yellow-500' : ($winner->winner_rank == 2 ? 'bg-gray-400' : 'bg-orange-600') }}">
                                        {{ $winner->getWinnerBadge() }}
                                    </span>
                                </div>
                                
                                <!-- Artwork -->
                                <a href="{{ route('guest.artworks.show', $winner->artwork) }}" 
                                   class="block border-4 {{ $winner->winner_rank == 1 ? 'border-yellow-400' : ($winner->winner_rank == 2 ? 'border-gray-400' : 'border-orange-400') }} rounded-lg overflow-hidden hover:opacity-90 transition">
                                    <img src="{{ Storage::url($winner->artwork->image_path) }}" 
                                         alt="{{ $winner->artwork->title }}"
                                         class="w-full h-64 object-cover">
                                </a>
                                
                                <!-- Info -->
                                <div class="mt-3">
                                    <a href="{{ route('guest.artworks.show', $winner->artwork) }}" 
                                       class="font-bold text-gray-800 hover:text-blue-900">
                                        {{ $winner->artwork->title }}
                                    </a>
                                    <p class="text-sm text-gray-600">
                                        by <a href="{{ route('guest.profile', $winner->user) }}" 
                                              class="hover:text-blue-900">
                                            {{ $winner->user->display_name }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Submissions Gallery -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Submissions ({{ $submissions->count() }})
                    </h2>
                    
                    @auth
                        @if(auth()->user()->isMember() && $challenge->canSubmit())
                            @if(!$hasSubmitted)
                                <a href="{{ route('member.artworks.index') }}" 
                                   class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition">
                                    Submit Your Work
                                </a>
                            @else
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                                    ✓ Submitted
                                </span>
                            @endif
                        @endif
                    @endauth
                </div>
                
                @if($submissions->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($submissions as $submission)
                            <div class="group">
                                <a href="{{ route('guest.artworks.show', $submission->artwork) }}" 
                                   class="block relative overflow-hidden rounded-lg">
                                    <img src="{{ Storage::url($submission->artwork->image_path) }}" 
                                         alt="{{ $submission->artwork->title }}"
                                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-300">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                                        <span class="text-white font-semibold opacity-0 group-hover:opacity-100 transition duration-300">
                                            View →
                                        </span>
                                    </div>
                                    
                                    <!-- Winner Badge on Submission -->
                                    @if($submission->isWinner())
                                        <div class="absolute top-2 left-2">
                                            <span class="px-2 py-1 rounded-full text-white font-bold text-xs {{ $submission->winner_rank == 1 ? 'bg-yellow-500' : ($submission->winner_rank == 2 ? 'bg-gray-400' : 'bg-orange-600') }}">
                                                {{ $submission->getWinnerBadge() }}
                                            </span>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="mt-2">
                                    <p class="font-medium text-sm truncate text-gray-800">
                                        {{ $submission->artwork->title }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        by {{ $submission->user->display_name }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No submissions yet</h3>
                        <p class="text-gray-600 mb-4">Be the first to submit your artwork!</p>
                        
                        @auth
                            @if(auth()->user()->isMember() && $challenge->canSubmit())
                                <a href="{{ route('member.artworks.index') }}" 
                                   class="inline-block bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition">
                                    Submit Your Artwork
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-800 transition">
                                Login to Submit
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar (Right 1/3) -->
        <div class="lg:col-span-1">
            <!-- Submit CTA (Only for Members & Active Challenge) -->
            @auth
                @if(auth()->user()->isMember())
                    @if($challenge->canSubmit())
                        @if(!$hasSubmitted)
                            <div class="bg-yellow-400 rounded-lg shadow-md p-6 mb-6">
                                <h3 class="font-bold text-blue-900 text-lg mb-2">
                                    💡 Ready to Compete?
                                </h3>
                                <p class="text-blue-900 text-sm mb-4">
                                    Submit your best artwork and have a chance to win amazing prizes!
                                </p>
                                <a href="{{ route('member.artworks.index') }}" 
                                   class="block w-full bg-blue-900 text-white text-center px-6 py-3 rounded-lg font-bold hover:bg-blue-800 transition">
                                    Choose Artwork to Submit
                                </a>
                            </div>
                        @else
                            <div class="bg-green-50 border-2 border-green-200 rounded-lg shadow-md p-6 mb-6">
                                <h3 class="font-bold text-green-800 text-lg mb-2">
                                    ✓ Submission Complete!
                                </h3>
                                <p class="text-green-700 text-sm mb-3">
                                    You've submitted your artwork to this challenge. Good luck!
                                </p>
                                <a href="{{ route('guest.artworks.show', $userSubmission->artwork) }}" 
                                   class="text-green-800 hover:text-green-900 font-semibold text-sm">
                                    View Your Submission →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 border-2 border-gray-300 rounded-lg shadow-md p-6 mb-6">
                            <h3 class="font-bold text-gray-700 text-lg mb-2">
                                Challenge Closed
                            </h3>
                            <p class="text-gray-600 text-sm">
                                This challenge is no longer accepting submissions.
                            </p>
                        </div>
                    @endif
                @endif
            @else
                @if($challenge->canSubmit())
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-2 border-blue-900">
                        <h3 class="font-bold text-gray-800 text-lg mb-2">
                            Want to Participate?
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Login or create an account to submit your artwork.
                        </p>
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" 
                               class="block w-full bg-blue-900 text-white text-center px-6 py-3 rounded-lg font-bold hover:bg-blue-800 transition">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="block w-full bg-yellow-400 text-blue-900 text-center px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition">
                                Sign Up Free
                            </a>
                        </div>
                    </div>
                @endif
            @endguest

            <!-- Challenge Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Challenge Timeline</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Start Date</p>
                            <p class="font-semibold text-gray-800">{{ $challenge->start_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $challenge->start_date->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">End Date</p>
                            <p class="font-semibold text-gray-800">{{ $challenge->end_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $challenge->end_date->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Total Submissions</p>
                            <p class="font-semibold text-gray-800">{{ $submissions->count() }} artworks</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organized By -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Organized by</h3>
                <a href="{{ route('guest.profile', $challenge->curator) }}" 
                   class="block group">
                    <div class="flex items-center mb-3">
                        @if($challenge->curator->profile_photo)
                            <img src="{{ Storage::url($challenge->curator->profile_photo) }}" 
                                 alt="{{ $challenge->curator->display_name }}"
                                 class="w-16 h-16 rounded-full object-cover mr-3">
                        @else
                            <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                                <span class="text-2xl text-blue-900 font-bold">{{ substr($challenge->curator->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-gray-800 group-hover:text-blue-900">
                                {{ $challenge->curator->display_name }}
                            </h4>
                            <p class="text-sm text-gray-600">View Profile →</p>
                        </div>
                    </div>
                </a>
                
                @if($challenge->curator->bio)
                    <p class="text-sm text-gray-600">
                        {{ Str::limit($challenge->curator->bio, 100) }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection