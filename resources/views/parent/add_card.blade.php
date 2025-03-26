@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Payment Method</h1>
                
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <form id="save-card-form" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="card-holder-name" class="block text-sm font-medium text-gray-700">Card Holder Name</label>
                                <input type="text" id="card-holder-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="space-y-2">
                                <label for="card-element" class="block text-sm font-medium text-gray-700">Card Details</label>
                                <div id="card-element" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border"></div>
                                <div id="card-errors" class="mt-2 text-red-600 text-sm hidden" role="alert"></div>
                            </div>
                            <button type="submit" id="save-card-button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span>Save Card</span>
                                <div class="hidden spinner">
                                    <svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    
    const style = {
        base: {
            color: '#6B7280',
            fontFamily: '"Figtree", sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#9CA3AF'
            },
            ':-webkit-autofill': {
                color: '#6B7280'
            }
        },
        invalid: {
            color: '#EF4444',
            iconColor: '#EF4444'
        }
    };

    const card = elements.create('card', { style: style });
    card.mount('#card-element');

    const form = document.getElementById('save-card-form');
    const cardErrors = document.getElementById('card-errors');
    const submitButton = document.getElementById('save-card-button');
    const spinner = submitButton.querySelector('.spinner');

    const setLoading = (isLoading) => {
        submitButton.disabled = isLoading;
        submitButton.querySelector('span').classList.toggle('hidden', isLoading);
        spinner.classList.toggle('hidden', !isLoading);
    };

    const displayError = (message) => {
        cardErrors.textContent = message;
        cardErrors.classList.remove('hidden');
    };

    const clearError = () => {
        cardErrors.textContent = '';
        cardErrors.classList.add('hidden');
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        setLoading(true);
        clearError();

        const cardHolderName = document.getElementById('card-holder-name').value;

        try {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                '{{ $setupIntent->client_secret }}',
                {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: cardHolderName
                        }
                    }
                }
            );

            if (error) {
                displayError(error.message);
                setLoading(false);
                return;
            }

            // Send the payment method ID to your server
            const response = await fetch('{{ route("payment.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_method: setupIntent.payment_method
                })
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = '{{ route("parent.payments") }}';
            } else {
                displayError(result.error || 'An error occurred while saving your card.');
            }
        } catch (error) {
            displayError(error.message || 'An unexpected error occurred.');
        } finally {
            setLoading(false);
        }
    });
</script>
@endpush