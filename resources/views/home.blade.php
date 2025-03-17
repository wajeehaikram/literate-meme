@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Online Tutoring Platform') }}</div>

                <div class="card-body">
                    <h2>Welcome to our Online Tutoring Platform</h2>
                    <p>Connect with qualified tutors and schedule your learning sessions today!</p>
                    
                    <div class="mt-4">
                        @guest
                            <div class="d-flex gap-3">
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="registerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Register
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="registerDropdown">
                                        <li><a class="dropdown-item" href="{{ route('register.tutor') }}">As Tutor</a></li>
                                        <li><a class="dropdown-item" href="{{ route('register.parent') }}">As Parent</a></li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">My Sessions</h5>
                                            <p class="card-text">View your upcoming and past tutoring sessions.</p>
                                            <a href="#" class="btn btn-primary">View Sessions</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Find Tutors</h5>
                                            <p class="card-text">Search for qualified tutors in various subjects.</p>
                                            <a href="#" class="btn btn-primary">Search Tutors</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection