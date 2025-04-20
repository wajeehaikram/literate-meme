@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Teaching Resources</h1>
                
                <!-- Resources Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Resources</h2>
                        <div>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Upload New Resource
                            </button>
                        </div>
                    </div>
                    
                    <!-- Resources List -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You haven't uploaded any resources yet.</p>
                            <p class="mt-2 text-sm">Upload lesson materials, worksheets, and other resources to share with your students.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Resource Categories -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Resource Categories</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Category 1 -->
                        <div class="bg-indigo-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300 h-full">
                            <h3 class="text-lg font-medium text-indigo-800 mb-2">Lesson Materials</h3>
                            <p class="text-gray-600 mb-4">Upload lesson plans, presentations, and teaching materials.</p>
                            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Browse Category
                            </button>
                        </div>
                        
                        <!-- Category 2 -->
                        <div class="bg-green-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300 h-full">
                            <h3 class="text-lg font-medium text-green-800 mb-2">Worksheets</h3>
                            <p class="text-gray-600 mb-4">Share practice worksheets and exercises with your students.</p>
                            <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                Browse Category
                            </button>
                        </div>
                        
                        <!-- Category 3 -->
                        <div class="bg-purple-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300 h-full">
                            <h3 class="text-lg font-medium text-purple-800 mb-2">Reference Materials</h3>
                            <p class="text-gray-600 mb-4">Upload helpful reference guides and supplementary materials.</p>
                            <button class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                Browse Category
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Resource Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Resource Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Organise resources by subject and topic for easy access</span></li>
                        <li><span class="text-gray-600">Use clear file names that describe the content</span></li>
                        <li><span class="text-gray-600">Upload resources in common file formats (PDF, DOCX, PPTX)</span></li>
                        <li><span class="text-gray-600">Share resources with students before and after sessions</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection