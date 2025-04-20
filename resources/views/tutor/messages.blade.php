@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-indigo-900 mb-6">Messages</h1>
                
                <!-- Messages Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Conversations</h2>
                        <!-- Message compose functionality removed -->
                    </div>
                    
                    <!-- Message List -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-md">
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
                                                    <p class="text-sm text-gray-500 truncate">{{ Str::limit($lastMessage->content, 50) }}</p>
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
                                <p class="mt-2 text-sm">When you receive messages from students or parents, they will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Message Tips -->
                <div class="bg-indigo-50 rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Communication Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Respond to messages within 24 hours</span></li>
                        <li><span class="text-gray-600">Keep communication professional and friendly</span></li>
                        <li><span class="text-gray-600">Use the messaging system for all student communications</span></li>
                        <li><span class="text-gray-600">Report any inappropriate messages to our support team</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
