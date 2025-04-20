@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit Child Details</h1>
                
                <form method="POST" action="{{ route('parent.children.update', $child) }}" id="editChildForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Child's Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $child->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Year Group -->
                    <div class="mb-6">
                        <label for="year_group" class="block text-sm font-medium text-gray-700 mb-1">Year Group</label>
                        <select name="year_group" id="year_group" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="">Select Year Group</option>
                            @for ($i = 1; $i <= 13; $i++)
                                <option value="Year {{ $i }}" {{ old('year_group', $child->year_group) == "Year {$i}" ? 'selected' : '' }}>Year {{ $i }}</option>
                            @endfor
                        </select>
                        @error('year_group')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Subjects -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Subjects</label>
                        <p class="text-sm text-gray-500 mb-4">Please select at least one subject</p>
                        
                        <div class="space-y-4" id="subjects-container">
                            @php
                                $subjects = ['Mathematics', 'English', 'Science', 'History', 'Geography', 'Computer Science'];
                                $examBoards = ['AQA', 'Edexcel', 'OCR', 'WJEC'];
                                $childSubjects = $child->subjects ?? [];
                            @endphp
                            
                            @foreach ($subjects as $index => $subject)
                                @php
                                    $isChecked = array_key_exists($subject, $childSubjects);
                                    $selectedBoard = $isChecked ? $childSubjects[$subject] : '';
                                @endphp
                                <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="subjects[]" id="subject_{{ $index }}" value="{{ $subject }}" class="subject-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" {{ $isChecked ? 'checked' : '' }}>
                                        <label for="subject_{{ $index }}" class="ml-2 block text-sm text-gray-700">{{ $subject }}</label>
                                    </div>
                                    
                                    <div class="exam-board-container {{ !$isChecked ? 'hidden' : '' }} md:ml-6">
                                        <label for="exam_board_{{ $index }}" class="block text-sm text-gray-700">Exam Board</label>
                                        <select name="exam_boards[]" id="exam_board_{{ $index }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" {{ !$isChecked ? 'disabled' : '' }}>
                                            <option value="">Select Exam Board</option>
                                            @foreach ($examBoards as $board)
                                                <option value="{{ $board }}" {{ $selectedBoard == $board ? 'selected' : '' }}>{{ $board }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @error('subjects')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" id="saveButton" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');
        const examBoardContainers = document.querySelectorAll('.exam-board-container');
        const examBoardSelects = document.querySelectorAll('[id^="exam_board_"]');
        const saveButton = document.getElementById('saveButton');
        
        // Function to check if at least one subject is selected
        function updateSaveButtonState() {
            const atLeastOneChecked = Array.from(subjectCheckboxes).some(checkbox => checkbox.checked);
            saveButton.disabled = !atLeastOneChecked;
        }
        
        // Add event listeners to all subject checkboxes
        subjectCheckboxes.forEach((checkbox, index) => {
            checkbox.addEventListener('change', function() {
                // Show/hide exam board dropdown
                if (this.checked) {
                    examBoardContainers[index].classList.remove('hidden');
                    examBoardSelects[index].disabled = false;
                    examBoardSelects[index].required = true;
                } else {
                    examBoardContainers[index].classList.add('hidden');
                    examBoardSelects[index].disabled = true;
                    examBoardSelects[index].required = false;
                    examBoardSelects[index].value = '';
                }
                
                // Update save button state
                updateSaveButtonState();
            });
        });
        
        // Initial check
        updateSaveButtonState();
    });
</script>
@endsection