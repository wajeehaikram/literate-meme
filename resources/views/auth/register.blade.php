@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Create an account
            </h1>
            
            <div class="flex flex-col space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h2 class="text-lg font-semibold text-blue-800 mb-2">Register as a Tutor</h2>
                    <p class="text-sm text-blue-600 mb-3">Create a tutor account to offer your teaching services</p>
                    <a href="{{ route('register.tutor') }}" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Register as Tutor</a>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h2 class="text-lg font-semibold text-green-800 mb-2">Register as a Parent</h2>
                    <p class="text-sm text-green-600 mb-3">Create a parent account to find tutors for your children</p>
                    <a href="{{ route('register.parent') }}" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Register as Parent</a>
                </div>
            </div>
            
            <p class="text-sm font-light text-gray-500 text-center">
                Already have an account? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection