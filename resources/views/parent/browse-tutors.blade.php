@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Browse Tutors</h1>
                    <div class="flex items-center">
                        <a href="{{ route('parent.messages') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Back to Messages
                        </a>
                        <a href="{{ route('parent.bookings') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            Back to Bookings
                        </a>
                    </div>
                </div>
                
                <!-- Filter Section -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Filter Tutors</h2>
                    
                    <form id="filter-form" method="GET" action="{{ route('parent.browse-tutors') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Subject Filters -->
                        <div>
                            <h3 class="text-md font-medium text-gray-700 mb-2">Subjects</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-mathematics" name="subjects[]" value="Mathematics" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Mathematics', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-mathematics" class="ml-2 text-sm text-gray-700">Mathematics</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-english" name="subjects[]" value="English Literature" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('English Literature', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-english" class="ml-2 text-sm text-gray-700">English</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-science" name="subjects[]" value="Science" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Science', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-science" class="ml-2 text-sm text-gray-700">Science</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-history" name="subjects[]" value="History" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('History', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-history" class="ml-2 text-sm text-gray-700">History</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-geography" name="subjects[]" value="Geography" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Geography', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-geography" class="ml-2 text-sm text-gray-700">Geography</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="subject-computer-science" name="subjects[]" value="Computer Science" class="subject-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Computer Science', request()->input('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject-computer-science" class="ml-2 text-sm text-gray-700">Computer Science</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Age Group Filters -->
                        <div>
                            <h3 class="text-md font-medium text-gray-700 mb-2">Age Groups</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="age-primary" name="age_groups[]" value="Primary School (4-11)" class="age-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Primary School (4-11)', request()->input('age_groups', [])) ? 'checked' : '' }}>
                                    <label for="age-primary" class="ml-2 text-sm text-gray-700">Primary School (4-11)</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="age-secondary" name="age_groups[]" value="Secondary School (11-16)" class="age-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Secondary School (11-16)', request()->input('age_groups', [])) ? 'checked' : '' }}>
                                    <label for="age-secondary" class="ml-2 text-sm text-gray-700">Secondary School (11-16)</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="age-sixth" name="age_groups[]" value="Sixth Form (16-18)" class="age-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Sixth Form (16-18)', request()->input('age_groups', [])) ? 'checked' : '' }}>
                                    <label for="age-sixth" class="ml-2 text-sm text-gray-700">Sixth Form (16-18)</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="age-university" name="age_groups[]" value="University (18+)" class="age-filter h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('University (18+)', request()->input('age_groups', [])) ? 'checked' : '' }}>
                                    <label for="age-university" class="ml-2 text-sm text-gray-700">University (18+)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 flex justify-end space-x-4">
                            <button type="submit" id="apply-filters" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">Apply Filters</button>
                            <a href="{{ route('parent.browse-tutors') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">Clear Filters</a>
                        </div>
                    </form>
                </div>
                
                <!-- Tutor Profiles Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Available Tutors</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 tutors-fade" id="tutors-grid">
                        <div class="tutors-spinner" id="tutors-spinner">
                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </div>
                        @forelse($tutors as $tutor)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 tutor-card">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                                            {{ strtoupper(substr($tutor->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $tutor->name }}</h3>
                                            <p class="text-sm text-indigo-600">£{{ number_format($tutor->tutorProfile->hourly_rate, 2) }}/hour</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-600 line-clamp-3">{{ $tutor->tutorProfile->bio }}</p>
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">Subjects</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($tutor->tutorProfile->subjects as $subject)
                                                    @php
                                                        $normalizedSubject = $subject;
                                                        if ($subject === 'English') $normalizedSubject = 'English Literature';
                                                        if ($subject === 'Maths') $normalizedSubject = 'Mathematics';
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs bg-indigo-50 text-indigo-700 rounded-full tutor-subject">{{ $normalizedSubject }}</span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">Qualifications</h4>
                                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                                @foreach($tutor->tutorProfile->qualifications as $qualification)
                                                    <li>{{ $qualification }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">Age Groups</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($tutor->tutorProfile->age_groups ?? [] as $ageGroup)
                                                    @php
                                                        $normalizedAgeGroup = $ageGroup;
                                                        if (str_contains($ageGroup, 'Primary')) $normalizedAgeGroup = 'Primary School';
                                                        elseif (str_contains($ageGroup, 'Secondary')) $normalizedAgeGroup = 'Secondary School';
                                                        elseif (str_contains($ageGroup, 'Sixth')) $normalizedAgeGroup = 'Sixth Form';
                                                        elseif (str_contains($ageGroup, 'University')) $normalizedAgeGroup = 'University';
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs bg-green-50 text-green-700 rounded-full tutor-age">{{ $normalizedAgeGroup }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <a href="{{ route('messages.show', $tutor->id) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            Contact Tutor
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="p-6 text-center text-gray-500">
                                    <p>No tutors are currently available.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tutors-fade {
        transition: opacity 0.4s, transform 0.3s ease-out;
        opacity: 1;
        position: relative;
        transform: translateY(0);
    }
    .tutors-fade.fading {
        opacity: 0.3;
        transform: translateY(10px);
    }
    .tutors-spinner {
        display: none;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale(0);
        z-index: 10;
        transition: transform 0.3s ease-out;
    }
    .tutors-fade.loading .tutors-spinner {
        display: block;
        transform: translate(-50%, -50%) scale(1);
    }
    
    /* Filter form transitions */
    #filter-form button,
    #filter-form a {
        transition: all 0.3s ease;
    }
    #filter-form button:active,
    #filter-form a:active {
        transform: scale(0.95);
    }
    
    /* Checkbox animation */
    .subject-filter,
    .age-filter {
        transition: all 0.2s ease;
    }
    .subject-filter:checked,
    .age-filter:checked {
        transform: scale(1.2);
    }
    
    /* Tutor card animations */
    .tutor-card {
        transition: all 0.3s ease;
        transform: translateY(0);
    }
    .tutor-card:hover {
        transform: translateY(-5px);
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all filter checkboxes
        const filterCheckboxes = document.querySelectorAll('.subject-filter, .age-filter');
        const filterForm = document.getElementById('filter-form');
        const tutorsGrid = document.getElementById('tutors-grid');
        const spinner = document.getElementById('tutors-spinner');
        
        // Apply filters button functionality
        const applyFiltersBtn = document.getElementById('apply-filters');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default form submission
                
                // Show loading state with animation
                tutorsGrid.classList.add('fading');
                tutorsGrid.classList.add('loading');
                
                // Add button press effect
                this.classList.add('scale-95');
                
                // Delay form submission for transition effect
                setTimeout(function() {
                    filterForm.submit();
                }, 400);
            });
        }
        
        // Remove automatic submission on checkbox change
        filterCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // No automatic submission
            });
        });
        
        // Clear filters button functionality
        const clearFiltersBtn = document.querySelector('a[href="{{ route("parent.browse-tutors") }}"]');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Uncheck all checkboxes
                filterCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                
                // Show loading state with animation
                tutorsGrid.classList.add('fading');
                tutorsGrid.classList.add('loading');
                
                // Add button press effect
                this.classList.add('scale-95');
                
                // Delay navigation for transition effect
                setTimeout(function() {
                    window.location.href = '{{ route("parent.browse-tutors") }}';
                }, 400);
            });
        }
    });
</script>
@endsection

@endsection