@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6 bg-white">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Payment Sessions</h1>
                <h2 class="text-xl font-medium text-gray-800 mb-4">Transaction History</h2>
                <div class="bg-white rounded-lg border border-gray-200 p-3 mb-8">
                    <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 mb-4" aria-label="Tabs">
                        <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Pending
                        </a>
                        <a href="#" class="border-transparent text-purple-500 hover:text-purple-700 hover:border-purple-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Completed
                        </a>
                    </nav>
                    </div>
                    @if(isset($payments) && count($payments) > 0)
                        <div class="w-full flex justify-center">
                            <div class="w-full divide-y divide-gray-200">
                                @foreach($payments as $payment)
                                    <div class="flex flex-col sm:flex-row sm:items-center px-6 py-6 border-b-2 border-gray-200 last:border-b-0">
                                        <div class="flex-1 text-center sm:text-left">
                                            <div class="font-semibold text-gray-800 text-lg mb-1">{{ $payment->tutoringSession->subject ?? 'Session' }}</div>
                                            <div class="text-gray-600 text-sm mb-1">
                                                {{ $payment->tutoringSession->start_time->format('l, d M Y H:i') ?? $payment->created_at->format('l, d M Y H:i') }}
                                                @if($payment->tutoringSession && $payment->tutoringSession->end_time)
                                                    - {{ $payment->tutoringSession->end_time->format('H:i') }}
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                Tutor: {{ $payment->tutoringSession->tutor->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-700 mt-1">
                                                Hourly Rate: <span class="font-semibold">£{{ number_format($payment->tutoringSession->tutorProfile->hourly_rate ?? 0, 2) }}</span>
                                            </div>
                                            <div class="text-sm text-gray-700 mt-1">
                                                Booking Ref: <span class="font-semibold">#{{ $payment->booking_id ?? 'N/A' }}</span>
                                            </div>
                                            <div class="text-sm text-gray-700 mt-1">
                                                Transaction ID: <span class="font-mono">{{ $payment->stripe_payment_id }}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center gap-2 mt-4 sm:mt-0 sm:justify-end min-w-[120px]">
                                            @if($payment->status === 'succeeded')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs mb-1">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs mb-1">
                                                    Unpaid
                                                </span>
                                            @endif
                                            @if($payment->status === 'succeeded')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($sessions->count())
                        <div class="w-full flex justify-center">
                            <div class="w-full divide-y divide-gray-200">
                                @foreach($sessions as $session)
                                    <div class="flex flex-col sm:flex-row sm:items-center px-6 py-6 border-b-2 border-gray-200 last:border-b-0">
                                        <div class="flex-1 text-center sm:text-left">
                                            <div class="font-semibold text-gray-800 text-lg mb-1">{{ $session->subject }}</div>
                                            <div class="text-gray-600 text-sm mb-1">
                                                {{ $session->start_time->format('l, d M Y H:i') }} - {{ $session->end_time->format('H:i') }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                Tutor: {{ $session->tutor->name }}
                                            </div>
                                            <div class="text-sm text-gray-700 mt-1">
                                                Hourly Rate: <span class="font-semibold">£{{ number_format($session->tutorProfile->hourly_rate, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 mt-4 sm:mt-0 sm:justify-end">
                                            @if($session->is_paid)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                                    Paid
                                                </span>
                                            @else
                                                <a href="{{ route('parent.payBooking', $session->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700 transition-colors">
                                                    Pay Now
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                @endforeach
                                
                            </div>
                        </div>
                    @endif

                </div>
                <!-- Payment Tips Section -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Payment Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Payments are processed securely through Stripe</span></li>
                        <li><span class="text-gray-600">Please pay within a week of a past booking</span></li>
                        <li><span class="text-gray-600">Double-check your payment amount before proceeding</span></li>
                        <li><span class="text-gray-600">Contact support if you do not receive a payment receipt</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection