@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Child</h1>
        <p class="mt-2 text-gray-600">Update your child's information</p>
    </div>

    <div class="mt-8 max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(Auth::check() && isset($child))
                <form method="POST" action="{{ route('child.update', $child->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ $child->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="year_group" class="block text-sm font-medium text-gray-700">Year Group</label>
                        <select name="year_group" id="year_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Year Group</option>
                            <option value="Reception" {{ $child->year_group == 'Reception' ? 'selected' : '' }}>Reception</option>
                            <option value="Year 1" {{ $child->year_group == 'Year 1' ? 'selected' : '' }}>Year 1</option>
                            <option value="Year 2" {{ $child->year_group == 'Year 2' ? 'selected' : '' }}>Year 2</option>
                            <option value="Year 3" {{ $child->year_group == 'Year 3' ? 'selected' : '' }}>Year 3</option>
                            <option value="Year 4" {{ $child->year_group == 'Year 4' ? 'selected' : '' }}>Year 4</option>
                            <option value="Year 5" {{ $child->year_group == 'Year 5' ? 'selected' : '' }}>Year 5</option>
                            <option value="Year 6" {{ $child->year_group == 'Year 6' ? 'selected' : '' }}>Year 6</option>
                            <option value="Year 7" {{ $child->year_group == 'Year 7' ? 'selected' : '' }}>Year 7</option>
                            <option value="Year 8" {{ $child->year_group == 'Year 8' ? 'selected' : '' }}>Year 8</option>
                            <option value="Year 9" {{ $child->year_group == 'Year 9' ? 'selected' : '' }}>Year 9</option>
                            <option value="Year 10" {{ $child->year_group == 'Year 10' ? 'selected' : '' }}>Year 10</option>
                            <option value="Year 11" {{ $child->year_group == 'Year 11' ? 'selected' : '' }}>Year 11</option>
                            <option value="Year 12" {{ $child->year_group == 'Year 12' ? 'selected' : '' }}>Year 12</option>
                            <option value="Year 13" {{ $child->year_group == 'Year 13' ? 'selected' : '' }}>Year 13</option>
                        </select>
                        @error('year_group')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Subjects</label>
                        <div class="mt-2 space-y-2">
                            @foreach(\App\Models\Subject::all() as $subject)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    name="subjects[]" 
                                    value="{{ $subject->id }}" 
                                    id="subject_{{ $subject->id }}" 
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    {{ $child->subjects->contains($subject->id) ? 'checked' : '' }}>
                                <label for="subject_{{ $subject->id }}" class="ml-2 text-sm text-gray-700">{{ $subject->name }}</label>
                                <div class="ml-4">
                                    <select name="exam_boards[]" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                           {{ !$child->subjects->contains($subject->id) ? 'disabled' : '' }}>
                                        <option value="">Select Exam Board</option>
                                        <option value="AQA" {{ $child->subjects->find($subject->id)?->pivot->exam_board === 'AQA' ? 'selected' : '' }}>AQA</option>
                                        <option value="Edexcel" {{ $child->subjects->find($subject->id)?->pivot->exam_board === 'Edexcel' ? 'selected' : '' }}>Edexcel</option>
                                        <option value="OCR" {{ $child->subjects->find($subject->id)?->pivot->exam_board === 'OCR' ? 'selected' : '' }}>OCR</option>
                                        <option value="WJEC" {{ $child->subjects->find($subject->id)?->pivot->exam_board === 'WJEC' ? 'selected' : '' }}>WJEC</option>
                                        <option value="Other" {{ $child->subjects->find($subject->id)?->pivot->exam_board === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('subjects')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-between mt-6">
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
                            Update Child
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <p class="text-gray-500">You need to be logged in to edit a child's information.</p>
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
    document.getElementById('editChildForm').addEventListener('submit', function(e) {
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