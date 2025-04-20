@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Messages</h1>
                    <a href="{{ route('parent.browse-tutors') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Tutors
                    </a>
                </div>
                
                <!-- Messages Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Conversations</h2>
                        <!-- Message compose functionality removed -->
                    </div>
                    
                    <!-- Message List -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        @if($conversations->count() > 0)
                            <div class="divide-y divide-gray-200">
                                @foreach($conversations as $userId => $convoMessages)
                                    @php
                                        $lastMessage = $convoMessages->first();
                                        $otherUser = $users[$userId] ?? null;
                                        $unreadCount = $convoMessages->where('is_read', false)
                                            ->where('receiver_id', Auth::id())
                                            ->count();
                                    @endphp
                                    @if($otherUser)
                                        <a href="{{ route('messages.show', $otherUser->id) }}" class="block hover:bg-gray-50 transition duration-150">
                                            <div class="p-4 flex justify-between items-center">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-base font-bold text-indigo-800 truncate mb-1">{{ $otherUser->name }}</p>
                                                    @php
                                                        $isBooking = false;
                                                        try {
                                                            $decoded = json_decode($lastMessage->content, true);
                                                            if (is_array($decoded) && ($decoded['type'] ?? null) === 'booking_suggestion') {
                                                                $isBooking = true;
                                                            }
                                                        } catch (Exception $e) {}
                                                    @endphp
                                                    <p class="text-sm text-gray-500 truncate">
                                                        @if($isBooking)
                                                            New booking
                                                        @else
                                                            {{ Str::limit($lastMessage->content, 50) }}
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $lastMessage->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if($unreadCount > 0)
                                                    <div class="ml-2 flex-shrink-0">
                                                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-indigo-600 text-white text-xs font-medium">{{ $unreadCount }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 text-center text-gray-500">
                                <p>You don't have any messages yet.</p>
                                <p class="mt-2 text-sm">When you receive messages from tutors, they will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Message Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Communication Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Expect responses from tutors within 24 hours</span></li>
                        <li><span class="text-gray-600">Keep communication professional and friendly</span></li>
                        <li><span class="text-gray-600">Use the messaging system for all tutor communications</span></li>
                        <li><span class="text-gray-600">Report any inappropriate messages to our support team</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection