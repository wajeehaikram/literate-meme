@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Payments</h1>
                
                <!-- Payment Methods Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Payment Methods</h2>
                        <div>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Add Payment Method
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any payment methods added yet.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction History Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Transaction History</h2>
                    </div>
                    
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200">
                            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                                <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    All Transactions
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Completed
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Pending
                                </a>
                            </nav>
                        </div>
                        
                        <div class="p-6 text-center text-gray-500">
                            <p>No transaction history available.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Payment Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Keep your payment methods up to date</span></li>
                        <li><span class="text-gray-600">Review transaction history regularly</span></li>
                        <li><span class="text-gray-600">Contact support for any payment issues</span></li>
                        <li><span class="text-gray-600">Ensure sufficient funds before booking sessions</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection