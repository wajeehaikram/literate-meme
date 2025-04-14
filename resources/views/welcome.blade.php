<!DOCTYPE html>
@extends('layouts.guest')

@section('content')
<style>
    /* Slideshow styles */
    .slideshow-container {
        position: relative;
        max-width: 100%;
        margin-top: 4rem;
        overflow: hidden;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    .slide {
        position: absolute;
        width: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
    }
    .slide img {
        width: 100%;
        height: 550px;
        object-fit: cover;
    }
    .slide.active {
        opacity: 1;
        visibility: visible;
        position: relative;
    }
    .slide-caption {
        position: absolute;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
        color: white;
        width: 100%;
        padding: 2rem 1.5rem 1.5rem;
        text-align: center;
    }
    .slide-caption h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    .slide-caption p {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 800px;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    .slide-nav {
        text-align: center;
        padding: 1rem 0;
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 20;
    }
    .slide-nav-dot {
        display: inline-block;
        height: 12px;
        width: 12px;
        margin: 0 6px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .slide-nav-dot:hover {
        background-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.2);
    }
    .slide-nav-dot.active {
        background-color: white;
        transform: scale(1.2);
        border: 2px solid rgba(79, 70, 229, 0.6);
    }

    @media (max-width: 768px) {
        .slide img {
            height: 350px;
        }
        .slide-caption h2 {
            font-size: 1.5rem;
        }
        .slide-caption p {
            font-size: 1rem;
        }
    }
</style>

    <!-- Slideshow Section -->
    <div class="slideshow-container">
        <div class="slide active">
            <img src="{{ asset('images/Slide_1.jpg') }}" alt="Slide 1">
            <div class="slide-caption">
                <h2>Welcome to LearnScape</h2>
                <p>Your journey to academic success starts here</p>
            </div>
        </div>
        <div class="slide">
            <img src="{{ asset('images/Slide_2.jpg') }}" alt="Slide 2">
            <div class="slide-caption">
                <h2>Expert Tutors</h2>
                <p>Learn from the best in every subject</p>
            </div>
        </div>
        <div class="slide">
            <img src="{{ asset('images/Slide_3.jpg') }}" alt="Slide 3">
            <div class="slide-caption">
                <h2>Flexible Learning</h2>
                <p>Study at your own pace, on your own schedule</p>
            </div>
        </div>
        <div class="slide">
            <img src="{{ asset('images/Slide_4.jpg') }}" alt="Slide 4">
            <div class="slide-caption">
                <h2>Achieve Your Goals</h2>
                <p>We're committed to your academic success</p>
            </div>
        </div>


        <div class="slide-nav">
            <span class="slide-nav-dot active" data-index="0"></span>
            <span class="slide-nav-dot" data-index="1"></span>
            <span class="slide-nav-dot" data-index="2"></span>
            <span class="slide-nav-dot" data-index="3"></span>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative pt-24">
        <div class="mx-auto max-w-7xl px-6 py-20 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Transform Your Learning Journey</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">Connect with expert tutors who are passionate about helping you succeed. Experience personalized learning that adapts to your needs and schedule.</p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-5 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Start Learning Today</a>
                    <a href="{{ route('about') }}" class="text-base font-semibold leading-6 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Active Tutors</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">50+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Students Helped</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">200+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Subjects Covered</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">6+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Success Rate</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">95%</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Why Choose LearnScape</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Everything you need to excel</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">Our platform provides the tools and support you need to achieve your academic goals.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <svg class="h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 8.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                <path fill-rule="evenodd" d="M10 0a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16z" clip-rule="evenodd" />
                            </svg>
                            Expert Tutors
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Connect with qualified and experienced tutors who specialize in your subject area.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <svg class="h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd" />
                            </svg>
                            Flexible Scheduling
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Book sessions that fit your schedule with our easy-to-use booking system.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <svg class="h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            Guaranteed Results
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Track your progress and achieve your academic goals with our structured learning approach.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSlide = 0;
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.slide-nav-dot');
            const prevButton = document.querySelector('.slide-prev');
            const nextButton = document.querySelector('.slide-next');
            const totalSlides = slides.length;
            let slideInterval;

            // Function to show a specific slide with smooth transition
            function showSlide(index) {
                // Hide all slides with smooth transition
                slides.forEach(slide => {
                    slide.classList.remove('active');
                    slide.style.zIndex = '0';
                });
                dots.forEach(dot => dot.classList.remove('active'));
                
                // Show the selected slide
                const targetSlide = slides[index];
                targetSlide.style.zIndex = '1';
                targetSlide.classList.add('active');
                dots[index].classList.add('active');
                
                // Update current slide index
                currentSlide = index;
            }

            // Function to show the next slide
            function nextSlide() {
                let nextIndex = currentSlide + 1;
                if (nextIndex >= totalSlides) {
                    nextIndex = 0;
                }
                showSlide(nextIndex);
            }

            // Function to show the previous slide
            function prevSlide() {
                let prevIndex = currentSlide - 1;
                if (prevIndex < 0) {
                    prevIndex = totalSlides - 1;
                }
                showSlide(prevIndex);
            }

            // Start automatic slideshow
            function startSlideshow() {
                slideInterval = setInterval(nextSlide, 3000);
            }

            // Stop automatic slideshow
            function stopSlideshow() {
                clearInterval(slideInterval);
            }

            // Event listeners for navigation dots
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const slideIndex = parseInt(this.getAttribute('data-index'));
                    showSlide(slideIndex);
                    stopSlideshow();
                    startSlideshow();
                });
            });


            // Pause slideshow when hovering over the slideshow container
            const slideshowContainer = document.querySelector('.slideshow-container');
            slideshowContainer.addEventListener('mouseenter', stopSlideshow);
            slideshowContainer.addEventListener('mouseleave', startSlideshow);

            // Start the slideshow
            startSlideshow();
        });
    </script>
@endsection
