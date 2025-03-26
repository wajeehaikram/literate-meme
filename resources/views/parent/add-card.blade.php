@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Add Payment Method</h1>
                
                <form id="save-card-form" class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label for="card-holder-name" class="block text-sm font-medium text-gray-700">Card Holder Name</label>
                            <input type="text" id="card-holder-name" name="card-holder-name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Enter card holder name">
                        </div>
                        
                        <!-- Stripe Card Element -->
                        <div>

                            <label for="card-element" class="block text-sm font-medium text-gray-700">Card Information</label>
                            <div id="card-element" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border" style="min-height: 40px; position: relative; z-index: 1;">
                                <!-- Stripe Card Element will be inserted here -->
                            </div>
                        </div>
                        
                        <div id="save-card-errors" role="alert" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span>Save Card</span>
                            <svg class="ml-2 -mr-1 h-5 w-5 hidden spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Stripe with your publishable key
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();
        
        // Define styles for the card element
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

        // Create the card element
        const cardElement = elements.create('card', { 
            style: style,
            hidePostalCode: false // Set to true if you don't need postal code
        });
        
        // Mount the card element to the DOM
        cardElement.mount('#card-element');
        console.log('Card element mounted');
        
        // Debug the card element
        setTimeout(() => {
            console.log('Card element status check:', document.querySelector('#card-element'));
            console.log('Card element children:', document.querySelector('#card-element').children);
            // Force focus on the card element
            document.querySelector('#card-element').click();
        }, 1000);
        
        // Add event listener for change events to display validation errors
        cardElement.addEventListener('change', function(event) {
            const errorElement = document.getElementById('save-card-errors');
            if (event.error) {
                errorElement.textContent = event.error.message;
                errorElement.classList.remove('hidden');
            } else {
                errorElement.textContent = '';
                errorElement.classList.add('hidden');
            }
        });
        
        const saveCardForm = document.getElementById('save-card-form');
        const cardHolderName = document.getElementById('card-holder-name');
        
        saveCardForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const saveButton = saveCardForm.querySelector('button');
            const spinner = saveButton.querySelector('.spinner');
            const buttonText = saveButton.querySelector('span');
            
            try {
                buttonText.classList.add('hidden');
                spinner.classList.remove('hidden');
                saveButton.disabled = true;
                
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    '{{ $setupIntent->client_secret }}',
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );
                
                if (error) {
                    throw new Error(error.message);
                }
                
                // Send the payment method to your server
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
                
                if (!response.ok) {
                    throw new Error('Failed to save card');
                }
                
                window.location.href = '{{ route("parent.payments") }}';
            } catch (error) {
                const errorElement = document.getElementById('save-card-errors');
                errorElement.textContent = error.message;
                errorElement.classList.remove('hidden');
            } finally {
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
                saveButton.disabled = false;
            }
        });
    });
</script>
@endpush