@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Pay for Booking</h1>
                <div class="mb-4">
                    <p class="text-gray-700">Please proceed to pay for your booking. You will be redirected to Stripe for secure payment.</p>
                </div>
                <form id="stripe-checkout-form" method="POST" action="{{ route('parent.payBooking', $id) }}">
                    @csrf
                    <button type="button" id="checkout-button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">Pay with Card</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.getElementById('checkout-button').addEventListener('click', function(e) {
        e.preventDefault();
        fetch("{{ route('parent.payBooking', $id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ booking_id: {{ $id }} })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sessionId) {
                var stripe = Stripe("pk_test_51R6934GovIlSgwu8IeQhphC4uBqCi2ril81r7GsNkMl8PDIetpWFVH1a6rVOkkEGrYFYEidWQn7rwrYV6yq9kSbs00xfIBVkFP");
                stripe.redirectToCheckout({ sessionId: data.sessionId });
            } else {
                alert('Failed to initiate payment.');
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    });
</script>
@endsection