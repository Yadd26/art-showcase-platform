@extends('layouts.guest')

@section('title', 'Browse Challenges')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Art Challenges</h1>
        <p class="text-xl text-gray-200">Participate in challenges and showcase your creativity</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white shadow-md sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8 overflow-x-auto">
            <a href="{{ route('guest.challenges.index', ['status' => 'active']) }}" 
               class="py-4 px-2 border-b-2 font-medium whitespace-nowrap {{ request('status', 'active') == 'active' ? 'border-yellow-400 text-blue-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                🔥 Active Challenges
            </a>
            <a href="{{ route('guest.challenges.index', ['status' => 'upcoming']) }}" 
               class="py-4 px-2 border-b-2 font-medium whitespace-nowrap {{ request('status') == 'upcoming' ? 'border-yellow-400 text-blue-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                📅 Upcoming
            </a>
            <a href="{{ route('guest.challenges.index', ['status' => 'ended']) }}" 
               class="py-4 px-2 border-b-2 font-medium whitespace-nowrap {{ request('status') == 'ended' ? 'border-yellow-400 text-blue-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                🏆 Past Challenges
            </a>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <form action="{{ route('guest.challenges.index') }}" method="GET" class="flex gap-4">
        <input type="hidden" name="status" value="{{ request('status', 'active') }}">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   placeholder="Search challenges by title or description..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
        </div>
        <button type="submit" 
                class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('guest.challenges.index', ['status' => request('status', 'active')]) }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Challenges Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    @if($challenges->count() > 0)
        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing <span class="font-semibold">{{ $challenges->count() }}</span> of 
                <span class="font-semibold">{{ $challenges->total() }}</span> 
                @if(request('status') == 'upcoming')
                    upcoming challenges
                @elseif(request('status') == 'ended')
                    past challenges
                @else
                    active challenges
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($challenges as $challenge)
                <x-challenge-card :challenge="$challenge" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $challenges->appends(['status' => request('status', 'active'), 'search' => request('search')])->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No challenges found</h3>
            <p class="text-gray-600 mb-6">
                @if(request('status') == 'upcoming')
                    No upcoming challenges at the moment. Check back soon!
                @elseif(request('status') == 'ended')
                    No past challenges to display.
                @else
                    No active challenges right now. Check upcoming or past challenges!
                @endif
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('guest.challenges.index', ['status' => 'active']) }}" 
                   class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    View Active Challenges
                </a>
            </div>
        </div>
    @endif
</section>

<!-- How It Works Section -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-blue-900 mb-8 text-center">How Challenges Work</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">📝</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">1. Choose a Challenge</h3>
                <p class="text-gray-600">Browse through active challenges and pick one that inspires you</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🎨</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">2. Create & Submit</h3>
                <p class="text-gray-600">Create your artwork and submit it before the deadline</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🏆</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">3. Win Prizes</h3>
                <p class="text-gray-600">Wait for the curator to announce winners and claim your prize!</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@guest
<section class="bg-gradient-to-r from-yellow-400 to-yellow-300 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-blue-900 mb-4">Ready to Showcase Your Talent?</h2>
        <p class="text-xl text-blue-800 mb-8">
            Join our community and participate in exciting art challenges!
        </p>
        <a href="{{ route('register') }}" 
           class="bg-blue-900 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition inline-block text-lg">
            Join as Creator
        </a>
    </div>
</section>
@endguest

@auth
    @if(auth()->user()->isCurator() && auth()->user()->isApproved())
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Want to Host a Challenge?</h2>
            <p class="text-xl text-gray-200 mb-8">
                As a curator, you can create challenges for the community!
            </p>
            <a href="{{ route('curator.challenges.create') }}" 
               class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg font-bold hover:bg-yellow-300 transition inline-block text-lg">
                Create Challenge
            </a>
        </div>
    </section>
    @endif
@endauth
@endsection