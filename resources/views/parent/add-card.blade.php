@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Process Payment</h1>
                
                <!-- Test Card Instructions -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h2 class="text-lg font-medium text-blue-800 mb-2">Test Card Details</h2>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Card Number: <span class="font-mono">4242 4242 4242 4242</span></li>
                        <li>• Expiry Date: Any future date (e.g., 12/30)</li>
                        <li>• CVC: Any 3 digits (e.g., 123)</li>
                        <li>• ZIP Code: Any 5 digits (e.g., 10001)</li>
                    </ul>
                </div>
                
                <!-- Payment Form Section -->
                <div class="mb-8">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden p-6">
                        <form id="payment-form" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (£)</label>
                                <input type="number" id="amount" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required min="1" step="0.01">
                            </div>
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label for="card-number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                            <input type="text" id="card-number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="4242 4242 4242 4242" required>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="col-span-1">
                                                <label for="card-expiry" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                                <input type="text" id="card-expiry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="MM/YY" required>
                                            </div>
                                            <div class="col-span-1">
                                                <label for="card-cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                                <input type="text" id="card-cvc" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="123" required>
                                            </div>
                                            <div class="col-span-1">
                                                <label for="card-zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                                <input type="text" id="card-zip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="10001" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="card-errors" class="mt-2 text-red-600 text-sm hidden" role="alert">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="submit-button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span id="button-text">Pay Now</span>
                                <div id="spinner" class="hidden">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

    const form = document.getElementById('payment-form');
    const cardNumber = document.getElementById('card-number');
    const cardExpiry = document.getElementById('card-expiry');
    const cardCvc = document.getElementById('card-cvc');
    const cardZip = document.getElementById('card-zip');
    const cardErrors = document.getElementById('card-errors');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    const setLoading = (isLoading) => {
        submitButton.disabled = isLoading;
        buttonText.classList.toggle('hidden', isLoading);
        spinner.classList.toggle('hidden', !isLoading);
    };

    const displayError = (message) => {
        cardErrors.querySelector('span').textContent = message;
        cardErrors.classList.remove('hidden');
    };

    const clearError = () => {
        cardErrors.querySelector('span').textContent = '';
        cardErrors.classList.add('hidden');
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        setLoading(true);
        clearError();
        const amount = document.getElementById('amount').value;

        try {
            const response = await fetch('{{ route("payment.intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ amount: amount })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            const { paymentMethod, error: createPaymentMethodError } = await stripe.createPaymentMethod({
                type: 'card',
                card: {
                    number: cardNumber.value,
                    exp_month: cardExpiry.value.split('/')[0],
                    exp_year: cardExpiry.value.split('/')[1],
                    cvc: cardCvc.value,
                },
                billing_details: {
                    address: {
                        postal_code: cardZip.value
                    }
                }
            });

            if (createPaymentMethodError) {
                displayError(createPaymentMethodError.message);
                setLoading(false);
                return;
            }

            const { error: confirmError, paymentIntent } = await stripe.confirmCardPayment(
                data.clientSecret,
                {
                    payment_method: paymentMethod.id
                }
            );

            if (confirmError) {
                displayError(confirmError.message);
                setLoading(false);
            } else if (paymentIntent.status === 'succeeded') {
                clearError();
                window.location.href = '{{ route("payment.success") }}';
            }
        } catch (error) {
            displayError('An error occurred while processing your payment. Please try again.');
            setLoading(false);
        }
    });

    // Input field validation and formatting
    cardNumber.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(.{4})/g, '$1 ').trim();
        e.target.value = value.substring(0, 19);
    });

    cardExpiry.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value.substring(0, 5);
    });

    cardCvc.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
    });

    cardZip.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 5);
    });
</script>
@endpush
@endsection