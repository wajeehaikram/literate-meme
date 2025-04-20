@extends('layouts.guest')

@section('content')
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Create an account
            </h1>
            
            <div class="flex flex-col space-y-4">
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <h2 class="text-lg font-semibold text-indigo-800 mb-2">Register as a Tutor</h2>
                    <p class="text-sm text-indigo-600 mb-3">Create a tutor account to offer your teaching services</p>
                    <a href="{{ route('register.tutor') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Register as Tutor</a>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <h2 class="text-lg font-semibold text-indigo-800 mb-2">Register as a Parent</h2>
                    <p class="text-sm text-indigo-600 mb-3">Create a parent account to find tutors for your children</p>
                    <a href="{{ route('register.parent') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Register as Parent</a>
                </div>
            </div>
            
            <p class="text-sm font-light text-gray-500 text-center">
                Already have an account? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection