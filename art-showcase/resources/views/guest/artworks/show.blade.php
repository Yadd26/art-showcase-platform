@extends('layouts.guest')

@section('title', $artwork->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('guest.artworks.index') }}" 
           class="inline-flex items-center text-blue-900 hover:text-yellow-500 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Artworks
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (Left Side) -->
        <div class="lg:col-span-2">
            <!-- Artwork Image -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <img src="{{ Storage::url($artwork->image_path) }}" 
                     alt="{{ $artwork->title }}"
                     class="w-full h-auto max-h-[600px] object-contain bg-gray-100">
            </div>

            <!-- Artwork Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $artwork->title }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $artwork->category->icon }} {{ $artwork->category->name }}
                        </span>
                    </div>
                    
                    <!-- Action Buttons (Only for Authenticated Members) -->
                    @auth
                        @if(auth()->user()->isMember())
                            <div class="flex space-x-2 ml-4">
                                <!-- Like Button -->
                                <form action="{{ route('member.artworks.like', $artwork) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="p-3 rounded-lg transition {{ $hasLiked ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-red-50' }}">
                                        <svg class="w-6 h-6" fill="{{ $hasLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Favorite Button -->
                                <form action="{{ route('member.artworks.favorite', $artwork) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="p-3 rounded-lg transition {{ $hasFavorited ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600 hover:bg-yellow-50' }}">
                                        <svg class="w-6 h-6" fill="{{ $hasFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Stats -->
                <div class="flex items-center space-x-6 text-gray-600 mb-4 pb-4 border-b">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                        </svg>
                        <span class="font-semibold">{{ $artwork->likes_count }}</span> likes
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">{{ $artwork->comments_count }}</span> comments
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z"></path>
                        </svg>
                        <span class="font-semibold">{{ $artwork->favorites_count }}</span> favorites
                    </span>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-600 whitespace-pre-line">{{ $artwork->description }}</p>
                </div>

                <!-- Tags -->
                @if($artwork->tags && count($artwork->tags) > 0)
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($artwork->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Report Button (Only for Members) -->
                @auth
                    @if(auth()->user()->isMember() && auth()->id() !== $artwork->user_id)
                        <div class="mt-6 pt-6 border-t">
                            <button onclick="openReportModal()" 
                                    class="text-red-600 hover:text-red-700 text-sm font-medium">
                                🚨 Report this artwork
                            </button>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    Comments ({{ $artwork->comments_count }})
                </h3>

                <!-- Add Comment Form (Only for Authenticated Members) -->
                @auth
                    @if(auth()->user()->isMember())
                        <form action="{{ route('member.artworks.comment', $artwork) }}" method="POST" class="mb-6">
                            @csrf
                            <textarea name="content" 
                                      rows="3" 
                                      placeholder="Write a comment..."
                                      required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent mb-2"></textarea>
                            <button type="submit" 
                                    class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                                Post Comment
                            </button>
                        </form>
                    @endif
                @else
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg text-center">
                        <p class="text-gray-600">
                            <a href="{{ route('login') }}" class="text-blue-900 hover:text-yellow-500 font-semibold">Login</a> 
                            to leave a comment
                        </p>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse($artwork->comments as $comment)
                        <div class="flex space-x-3 pb-4 border-b border-gray-200 last:border-0">
                            <!-- Avatar -->
                            @if($comment->user->profile_photo)
                                <img src="{{ Storage::url($comment->user->profile_photo) }}" 
                                     alt="{{ $comment->user->display_name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-900 font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <a href="{{ route('guest.profile', $comment->user) }}" 
                                           class="font-semibold text-gray-800 hover:text-blue-900">
                                            {{ $comment->user->display_name }}
                                        </a>
                                        <span class="text-xs text-gray-500 ml-2">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    @auth
                                        @if(auth()->id() === $comment->user_id)
                                            <form action="{{ route('member.comments.destroy', $comment) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Delete this comment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="text-gray-600">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar (Right Side) -->
        <div class="lg:col-span-1">
            <!-- Artist Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">About the Artist</h3>
                <a href="{{ route('guest.profile', $artwork->user) }}" class="block group">
                    <div class="flex items-center mb-3">
                        @if($artwork->user->profile_photo)
                            <img src="{{ Storage::url($artwork->user->profile_photo) }}" 
                                 alt="{{ $artwork->user->display_name }}"
                                 class="w-16 h-16 rounded-full object-cover mr-3">
                        @else
                            <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                                <span class="text-2xl text-blue-900 font-bold">{{ substr($artwork->user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-gray-800 group-hover:text-blue-900">
                                {{ $artwork->user->display_name }}
                            </h4>
                            <p class="text-sm text-gray-600">View Profile →</p>
                        </div>
                    </div>
                </a>
                
                @if($artwork->user->bio)
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($artwork->user->bio, 100) }}</p>
                @endif
                
                @if($artwork->user->external_link)
                    <a href="{{ $artwork->user->external_link }}" 
                       target="_blank"
                       class="text-sm text-blue-900 hover:text-yellow-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Visit Website
                    </a>
                @endif
            </div>

            <!-- Upload Date -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Published</h3>
                <p class="text-gray-600">{{ $artwork->created_at->format('F d, Y') }}</p>
                <p class="text-sm text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
            </div>

            <!-- Related Artworks -->
            @if($relatedArtworks->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">More from {{ $artwork->category->name }}</h3>
                    <div class="space-y-4">
                        @foreach($relatedArtworks as $related)
                            <a href="{{ route('guest.artworks.show', $related) }}" class="block group">
                                <div class="flex space-x-3">
                                    <img src="{{ Storage::url($related->image_path) }}" 
                                         alt="{{ $related->title }}"
                                         class="w-20 h-20 object-cover rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-800 group-hover:text-blue-900 truncate">
                                            {{ $related->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $related->user->display_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $related->likes_count }} likes</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Report Modal -->
@auth
    @if(auth()->user()->isMember() && auth()->id() !== $artwork->user_id)
        <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Report Artwork</h3>
                    <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('member.artworks.report', $artwork) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                        <select name="reason" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select a reason</option>
                            <option value="SARA">SARA Content</option>
                            <option value="Plagiat">Plagiarism</option>
                            <option value="Konten Tidak Pantas">Inappropriate Content</option>
                            <option value="Spam">Spam</option>
                            <option value="Lainnya">Other</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Details (Optional)</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeReportModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth

@push('scripts')
<script>
    function openReportModal() {
        document.getElementById('reportModal').classList.remove('hidden');
    }
    
    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
    }
</script>
@endpush
@endsection