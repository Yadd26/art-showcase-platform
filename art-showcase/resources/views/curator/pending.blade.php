<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Under Review - ArtShowcase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <!-- Icon -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-blue-900 mb-4">
                    Account Under Review
                </h1>

                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    Thank you for registering as a Curator! Your account is currently being reviewed by our admin team.
                </p>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        <strong>What happens next?</strong><br>
                        Our team will review your curator application. You'll receive access to create challenges once approved. This usually takes 1-2 business days.
                    </p>
                </div>

                <!-- Info -->
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <p>
                        <strong>Account:</strong> {{ auth()->user()->email }}
                    </p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending Approval
                        </span>
                    </p>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" 
                       class="block w-full bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Browse Artworks
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
                    Need help? Contact us at support@artshowcase.com
                </p>
            </div>
        </div>
    </div>
</body>
</html>