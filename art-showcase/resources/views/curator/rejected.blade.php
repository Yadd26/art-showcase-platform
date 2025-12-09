<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Rejected - ArtShowcase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <!-- Icon -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-red-600 mb-4">
                    Application Not Approved
                </h1>

                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    Unfortunately, your curator application has not been approved at this time.
                </p>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-red-800">
                        Your curator application did not meet our requirements. However, you can still join as a Member to upload and showcase your artworks!
                    </p>
                </div>

                <!-- Info -->
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <p>
                        <strong>Account:</strong> {{ auth()->user()->email }}
                    </p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                            Rejected
                        </span>
                    </p>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('curator.account.delete') }}" 
                          onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="block w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                            Delete Account
                        </button>
                    </form>

                    <a href="{{ route('home') }}" 
                       class="block w-full bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Browse as Guest
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="block w-full bg-white text-gray-700 px-6 py-3 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Help -->
                <p class="text-xs text-gray-500 mt-6">
                    Questions? Contact us at support@artshowcase.com
                </p>
            </div>
        </div>
    </div>
</body>
</html>