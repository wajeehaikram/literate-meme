@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Update Your Availability</h2>
                
                <form action="{{ route('tutor.availability.update') }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Period</th>
                                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $periods = [
                                        ['label' => 'Pre 12pm', 'icon' => '☀️'],
                                        ['label' => '12 - 5pm', 'icon' => '⌚'],
                                        ['label' => 'After 5pm', 'icon' => '🌙']
                                    ];
                                @endphp
                                @foreach($periods as $period)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center gap-2">
                                                <span>{{ $period['icon'] }}</span>
                                                <span>{{ $period['label'] }}</span>
                                            </div>
                                        </td>
                                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" 
                                                           name="availability[{{ $day }}][{{ str_replace(' ', '_', strtolower($period['label'])) }}]" 
                                                           class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                                           {{ old('availability.' . $day . '.' . str_replace(' ', '_', strtolower($period['label'])), $schedule[ucfirst($day)][str_replace(' ', '_', strtolower($period['label']))] ?? false) ? 'checked' : '' }}>
                                                    <span class="sr-only">Available on {{ $day }} {{ $period['label'] }}</span>
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Availability
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection