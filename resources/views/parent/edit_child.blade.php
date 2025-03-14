@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Child</h1>
        <p class="mt-2 text-gray-600">Update your child's information</p>
    </div>

    <div class="mt-8 max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('child.update', $child->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ $child->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="year_group" class="block text-sm font-medium text-gray-700">Year Group</label>
                        <select name="year_group" id="year_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                    </div>
                    
                    <div class="mb-4">
                        <label for="exam_board" class="block text-sm font-medium text-gray-700">Exam Board</label>
                        <select name="exam_board" id="exam_board" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="AQA" {{ $child->exam_board == 'AQA' ? 'selected' : '' }}>AQA</option>
                            <option value="Edexcel" {{ $child->exam_board == 'Edexcel' ? 'selected' : '' }}>Edexcel</option>
                            <option value="OCR" {{ $child->exam_board == 'OCR' ? 'selected' : '' }}>OCR</option>
                            <option value="WJEC" {{ $child->exam_board == 'WJEC' ? 'selected' : '' }}>WJEC</option>
                            <option value="Other" {{ $child->exam_board == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update Child
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection