@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Payments</h1>
        <p class="mt-2 text-gray-600">Manage your payment methods and view transaction history.</p>
    </div>

    <div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Payment Methods</h2>
                    <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add Payment Method
                    </button>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-500 text-sm text-center py-8">You don't have any payment methods added yet.</p>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Transaction History</h2>
                
                <div class="border-t border-gray-200 pt-4">
                    <!-- Tabs for filtering transactions -->
                    <div class="border-b border-gray-200 mb-4">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
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
                    
                    <p class="text-gray-500 text-sm text-center py-8">No transaction history available.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection