<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-900 to-blue-700 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-400 rounded-lg mb-4">
                    <span class="text-4xl">🎨</span>
                </div>
                <h2 class="text-3xl font-bold text-blue-900">Join ArtShowcase</h2>
                <p class="text-gray-600 mt-2">Create your account to start showcasing</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                    </label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-900 focus:border-blue-900">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-900 focus:border-blue-900">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        I want to join as
                    </label>
                    <div class="space-y-3">
                        <!-- Member Option -->
                        <label class="relative flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-900 transition has-[:checked]:border-blue-900 has-[:checked]:bg-blue-50">
                            <input type="radio" 
                                   name="role" 
                                   value="member" 
                                   {{ old('role', 'member') === 'member' ? 'checked' : '' }}
                                   class="mt-1 h-4 w-4 text-blue-900 focus:ring-blue-900">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">
                                    🎨 Member (Creator)
                                </span>
                                <span class="block text-sm text-gray-600">
                                    Upload and showcase your artworks, participate in challenges
                                </span>
                            </div>
                        </label>

                        <!-- Curator Option -->
                        <label class="relative flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-900 transition has-[:checked]:border-blue-900 has-[:checked]:bg-blue-50">
                            <input type="radio" 
                                   name="role" 
                                   value="curator" 
                                   {{ old('role') === 'curator' ? 'checked' : '' }}
                                   class="mt-1 h-4 w-4 text-blue-900 focus:ring-blue-900">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">
                                    🏆 Curator
                                </span>
                                <span class="block text-sm text-gray-600">
                                    Create and manage art challenges for the community
                                </span>
                                <span class="block text-xs text-yellow-700 mt-1">
                                    ⚠️ Requires admin approval
                                </span>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-900 focus:border-blue-900">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-900 focus:border-blue-900">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-blue-900 bg-yellow-400 hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-blue-900 hover:text-yellow-500 transition">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>