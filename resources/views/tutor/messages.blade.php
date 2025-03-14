@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Messages</h1>
                
                <!-- Messages Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Conversations</h2>
                        <div>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                New Message
                            </button>
                        </div>
                    </div>
                    
                    <!-- Message List -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any messages yet.</p>
                            <p class="mt-2 text-sm">When you receive messages from students or parents, they will appear here.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Message Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
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