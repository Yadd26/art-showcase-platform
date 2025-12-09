@extends('layouts.app')

@section('title', 'Create Challenge')
@section('page-title', 'Create New Challenge')

@section('sidebar')
    <a href="{{ route('curator.dashboard') }}" 
       class="flex items-center px-4 py-3 hover:bg-blue-800 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>
    
    <a href="{{ route('curator.challenges.index') }}" 
       class="flex items-center px-4 py-3 bg-blue-800 rounded-lg font-medium">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
        </svg>
        My Challenges
    </a>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('curator.challenges.index') }}" 
               class="inline-flex items-center text-blue-900 hover:text-yellow-500 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Challenges
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Challenge</h2>

            <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Challenge Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           required
                           placeholder="e.g., Digital Art Showcase 2025"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="6"
                              required
                              placeholder="Describe your challenge, what participants should create, and what makes it special..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rules -->
                <div class="mb-6">
                    <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">
                        Rules & Guidelines <span class="text-red-500">*</span>
                    </label>
                    <textarea id="rules" 
                              name="rules" 
                              rows="6"
                              required
                              placeholder="List the rules and guidelines for participants..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('rules') border-red-500 @enderror">{{ old('rules') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Each line will be displayed as a separate rule</p>
                    @error('rules')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prize Pool & Winners -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Prize Pool -->
                    <div>
                        <label for="prize_pool" class="block text-sm font-medium text-gray-700 mb-2">
                            Prize Pool (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="prize_pool" 
                               name="prize_pool" 
                               value="{{ old('prize_pool') }}"
                               required
                               min="0"
                               step="1000"
                               placeholder="5000000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('prize_pool') border-red-500 @enderror">
                        @error('prize_pool')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Winners -->
                    <div>
                        <label for="max_winners" class="block text-sm font-medium text-gray-700 mb-2">
                            Number of Winners <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="max_winners" 
                               name="max_winners" 
                               value="{{ old('max_winners', 3) }}"
                               required
                               min="1"
                               max="10"
                               placeholder="3"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('max_winners') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">How many winners will you select (1-10)?</p>
                        @error('max_winners')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Banner Image -->
                <div class="mb-6">
                    <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Banner Image
                    </label>
                    <input type="file" 
                           id="banner_image" 
                           name="banner_image" 
                           accept="image/jpeg,image/jpg,image/png,image/webp"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('banner_image') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Optional. JPG, PNG, or WEBP. Max 5MB. Recommended: 1200x400px</p>
                    @error('banner_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-900 shadow-sm focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Make this challenge active immediately</span>
                    </label>
                    <p class="mt-1 ml-6 text-xs text-gray-500">Uncheck if you want to publish it later</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('curator.challenges.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition">
                        Create Challenge
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection