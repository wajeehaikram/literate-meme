@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit Profile</h1>
                
                <form method="POST" action="{{ route('tutor.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Password Update Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Update Password</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $tutorProfile->bio }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subjects</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label><input type="checkbox" name="subjects[]" value="Mathematics" {{ in_array('Mathematics', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> Mathematics</label>
                                    <label><input type="checkbox" name="subjects[]" value="English" {{ in_array('English', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> English</label>
                                    <label><input type="checkbox" name="subjects[]" value="Science" {{ in_array('Science', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> Science</label>
                                    <label><input type="checkbox" name="subjects[]" value="History" {{ in_array('History', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> History</label>
                                    <label><input type="checkbox" name="subjects[]" value="Geography" {{ in_array('Geography', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> Geography</label>
                                    <label><input type="checkbox" name="subjects[]" value="Computer Science" {{ in_array('Computer Science', $tutorProfile->subjects ?? []) ? 'checked' : '' }}> Computer Science</label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Age Groups</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label><input type="checkbox" name="age_groups[]" value="Primary School (4-11)" {{ in_array('Primary School (4-11)', $tutorProfile->age_groups ?? []) ? 'checked' : '' }}> Primary School (4-11)</label>
                                    <label><input type="checkbox" name="age_groups[]" value="Secondary School (11-16)" {{ in_array('Secondary School (11-16)', $tutorProfile->age_groups ?? []) ? 'checked' : '' }}> Secondary School (11-16)</label>
                                    <label><input type="checkbox" name="age_groups[]" value="Sixth Form (16-18)" {{ in_array('Sixth Form (16-18)', $tutorProfile->age_groups ?? []) ? 'checked' : '' }}> Sixth Form (16-18)</label>
                                    <label><input type="checkbox" name="age_groups[]" value="University (18+)" {{ in_array('University (18+)', $tutorProfile->age_groups ?? []) ? 'checked' : '' }}> University (18+)</label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label><input type="checkbox" name="qualifications[]" value="Bachelor's Degree" {{ in_array("Bachelor's Degree", $tutorProfile->qualifications ?? []) ? 'checked' : '' }}> Bachelor's Degree</label>
                                    <label><input type="checkbox" name="qualifications[]" value="Master's Degree" {{ in_array("Master's Degree", $tutorProfile->qualifications ?? []) ? 'checked' : '' }}> Master's Degree</label>
                                    <label><input type="checkbox" name="qualifications[]" value="PhD" {{ in_array("PhD", $tutorProfile->qualifications ?? []) ? 'checked' : '' }}> PhD</label>
                                    <label><input type="checkbox" name="qualifications[]" value="Teaching Certificate" {{ in_array("Teaching Certificate", $tutorProfile->qualifications ?? []) ? 'checked' : '' }}> Teaching Certificate</label>
                                </div>
                            </div>
                            
                            <div>
                                <label for="qualifications" class="block text-sm font-medium text-gray-700">Qualifications</label>
                                <textarea name="qualifications" id="qualifications" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ json_encode($tutorProfile->qualifications) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Enter your qualifications, one per line</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('tutor.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-500">Cancel</a>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection