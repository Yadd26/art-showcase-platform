@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-yellow-400 rounded-xl flex items-center justify-center mb-4">
                <span class="text-4xl">🎨</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
                Join ArtShowcase
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Create your account and start showcasing your art
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="John Doe"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required 
                           autocomplete="username"
                           placeholder="your@email.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Minimum 8 characters"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Re-enter your password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Register As <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <!-- Member Option -->
                        <label class="relative flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-900 transition @error('role') border-red-500 @enderror">
                            <input type="radio" 
                                   name="role" 
                                   value="member" 
                                   {{ old('role', 'member') == 'member' ? 'checked' : '' }}
                                   class="mt-1 h-4 w-4 text-blue-900 focus:ring-blue-900">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-2">🎨</span>
                                    <span class="font-bold text-gray-900">Member (Creator)</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    Upload artworks, participate in challenges, and engage with the community
                                </p>
                                <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                                    ✓ Instant Approval
                                </span>
                            </div>
                        </label>

                        <!-- Curator Option -->
                        <label class="relative flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-900 transition">
                            <input type="radio" 
                                   name="role" 
                                   value="curator" 
                                   {{ old('role') == 'curator' ? 'checked' : '' }}
                                   class="mt-1 h-4 w-4 text-blue-900 focus:ring-blue-900">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-2">👨‍⚖️</span>
                                    <span class="font-bold text-gray-900">Curator</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    Create and manage art challenges, select winners, organize events
                                </p>
                                <span class="inline-block mt-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">
                                    ⏳ Requires Admin Approval
                                </span>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-900 text-white py-3 px-4 rounded-lg font-bold hover:bg-blue-800 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Already have an account?
                        </span>
                    </div>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-6">
                <a href="{{ route('login') }}" 
                   class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Login Instead
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
            <p class="font-semibold text-blue-900 mb-2">ℹ️ Registration Info:</p>
            <ul class="space-y-1 text-blue-800 text-xs">
                <li>• <strong>Member</strong> accounts are approved instantly</li>
                <li>• <strong>Curator</strong> accounts require admin approval</li>
                <li>• You'll receive an email once your account is activated</li>
            </ul>
        </div>
    </div>
</div>
@endsection