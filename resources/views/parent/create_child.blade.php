@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Add New Child</h1>
        <p class="mt-2 text-gray-600">Please fill out the form below to add a new child to your account.</p>
    </div>

    <div class="mt-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(Auth::check())
                <form method="POST" action="{{ route('child.store') }}" id="addChildForm">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Child's Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="year_group" class="block text-sm font-medium text-gray-700">Year Group</label>
                        <select name="year_group" id="year_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Year Group</option>
                            <option value="Reception">Reception</option>
                            <option value="Year 1">Year 1</option>
                            <option value="Year 2">Year 2</option>
                            <option value="Year 3">Year 3</option>
                            <option value="Year 4">Year 4</option>
                            <option value="Year 5">Year 5</option>
                            <option value="Year 6">Year 6</option>
                            <option value="Year 7">Year 7</option>
                            <option value="Year 8">Year 8</option>
                            <option value="Year 9">Year 9</option>
                            <option value="Year 10">Year 10</option>
                            <option value="Year 11">Year 11</option>
                            <option value="Year 12">Year 12</option>
                            <option value="Year 13">Year 13</option>
                        </select>
                        @error('year_group')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjects and Exam Boards</label>
                        <p class="text-sm text-gray-500 mb-4">Select the subjects and their respective exam boards</p>
                        
                        <div class="space-y-4">
                            @foreach(\App\Models\Subject::all() as $subject)
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" 
                                           id="subject_{{ $subject->id }}" 
                                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="subject_{{ $subject->id }}" class="ml-2 text-sm text-gray-700">{{ $subject->name }}</label>
                                </div>
                                <div class="flex-grow">
                                    <select name="exam_boards[]" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Select Exam Board</option>
                                        <option value="AQA">AQA</option>
                                        <option value="Edexcel">Edexcel</option>
                                        <option value="OCR">OCR</option>
                                        <option value="WJEC">WJEC</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('subjects')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Add Child
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <p class="text-gray-500">You need to be logged in to add a child.</p>
                    <a href="{{ route('login') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Login</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('addChildForm').addEventListener('submit', function(e) {
        const subjectCheckboxes = document.querySelectorAll('input[name="subjects[]"]');
        const examBoardSelects = document.querySelectorAll('select[name="exam_boards[]"]');
        
        let hasSelectedSubject = false;
        let isValid = true;
        
        subjectCheckboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                hasSelectedSubject = true;
                const examBoardValue = examBoardSelects[index].value;
                if (!examBoardValue) {
                    isValid = false;
                    examBoardSelects[index].classList.add('border-red-500');
                } else {
                    examBoardSelects[index].classList.remove('border-red-500');
                }
            }
        });
        
        if (!hasSelectedSubject) {
            e.preventDefault();
            alert('Please select at least one subject');
            return;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please select an exam board for all checked subjects');
            return;
        }
    });

    // Enable/disable exam board dropdowns based on subject selection
    document.querySelectorAll('input[name="subjects[]"]').forEach((checkbox, index) => {
        const examBoardSelect = document.querySelectorAll('select[name="exam_boards[]"]')[index];
        
        // Set initial state
        examBoardSelect.disabled = !checkbox.checked;
        
        checkbox.addEventListener('change', function() {
            examBoardSelect.disabled = !this.checked;
            if (!this.checked) {
                examBoardSelect.value = '';
                examBoardSelect.classList.remove('border-red-500');
            }
        });
    });
</script>
@endpush