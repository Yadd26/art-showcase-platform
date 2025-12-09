@extends('layouts.app')

@section('title', 'Curator Dashboard')
@section('page-title', 'Curator Dashboard')

@section('sidebar')
    <a href="{{ route('curator.dashboard') }}" 
       class="flex items-center px-4 py-3 bg-blue-800 rounded-lg font-medium">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>
    
    <a href="{{ route('curator.challenges.index') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
        </svg>
        My Challenges
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Challenges -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Challenges</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_challenges'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Challenges -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Challenges</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['active_challenges'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Ended Challenges -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Ended Challenges</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['ended_challenges'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Needed -->
    @if($needsWinnerSelection->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-lg font-semibold text-yellow-800">Action Required</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        You have {{ $needsWinnerSelection->count() }} ended challenge(s) that need winner selection.
                    </p>
                    <div class="mt-4 space-y-2">
                        @foreach($needsWinnerSelection as $challenge)
                            <div class="flex items-center justify-between bg-white rounded p-3">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $challenge->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $challenge->submissions_count }} submissions</p>
                                </div>
                                <a href="{{ route('curator.challenges.submissions', $challenge) }}" 
                                   class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition text-sm">
                                    Select Winners
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Active Challenges -->
        @if($activeChallenges->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Active Challenges</h2>
                    <a href="{{ route('curator.challenges.index') }}" class="text-blue-900 hover:text-yellow-500 font-medium text-sm">
                        View All →
                    </a>
                </div>
                
                <div class="space-y-3">
                    @foreach($activeChallenges as $challenge)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $challenge->title }}</h3>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">{{ $challenge->submissions_count }} submissions</span>
                                <span class="text-green-600 font-medium">Active</span>
                            </div>
                            <div class="mt-2 flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ends {{ $challenge->end_date->diffForHumans() }}
                            </div>
                            <a href="{{ route('curator.challenges.submissions', $challenge) }}" 
                               class="mt-3 inline-block text-sm text-blue-900 hover:text-yellow-500 font-medium">
                                View Submissions →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Challenges -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Recent Challenges</h2>
                <a href="{{ route('curator.challenges.create') }}" 
                   class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition text-sm inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Challenge
                </a>
            </div>
            
            <div class="space-y-3">
                @forelse($recentChallenges as $challenge)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800">{{ $challenge->title }}</h3>
                            @if($challenge->isActive())
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Active</span>
                            @elseif($challenge->hasEnded())
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">Ended</span>
                            @else
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Upcoming</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $challenge->submissions_count }} submissions</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('curator.challenges.edit', $challenge) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800">
                                Edit
                            </a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('curator.challenges.submissions', $challenge) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800">
                                Submissions
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">No challenges yet</p>
                        <a href="{{ route('curator.challenges.create') }}" 
                           class="inline-block bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition">
                            Create Your First Challenge
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection