@extends('layouts.app')

@section('title', 'Results - University Course Management')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            @if(auth()->user()->isAdmin())
                All Results
            @else
                My Results
            @endif
        </h1>
        <p class="text-gray-600">View academic performance and grades</p>
    </div>
    
    @if(auth()->user()->isAdmin())
    <a href="{{ route('results.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
        <i class="fas fa-plus mr-2"></i>Add Result
    </a>
    @endif
</div>

@if($results->count() > 0)
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @if(auth()->user()->isAdmin())
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    @endif
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Date</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($results as $result)
                <tr class="hover:bg-gray-50">
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="font-medium text-gray-900">{{ $result->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $result->user->student_id }}</div>
                        </div>
                    </td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="font-medium text-gray-900">{{ $result->course->code }}</div>
                            <div class="text-sm text-gray-500">{{ $result->course->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                            @if(in_array($result->grade, ['A+', 'A', 'A-'])) bg-green-100 text-green-800
                            @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) bg-blue-100 text-blue-800
                            @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $result->grade }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $result->points }}/100
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $result->course->credits }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $result->exam_date ? $result->exam_date->format('M d, Y') : 'N/A' }}
                    </td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('results.show', $result) }}" class="text-blue-600 hover:text-blue-500">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('results.edit', $result) }}" class="text-yellow-600 hover:text-yellow-500">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('results.destroy', $result) }}" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this result?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-500">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $results->links() }}
</div>

@if(auth()->user()->isStudent())
<!-- GPA Summary -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Academic Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $results->count() }}</p>
            <p class="text-sm text-gray-600">Completed Courses</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-green-600">{{ $results->sum(function($result) { return $result->course->credits; }) }}</p>
            <p class="text-sm text-gray-600">Total Credits</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-purple-600">
                @php
                    $totalPoints = 0;
                    $totalCredits = 0;
                    foreach($results as $result) {
                        $totalPoints += $result->gpa_points * $result->course->credits;
                        $totalCredits += $result->course->credits;
                    }
                    $gpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
                @endphp
                {{ $gpa }}
            </p>
            <p class="text-sm text-gray-600">Cumulative GPA</p>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="{{ route('transcript') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-download mr-2"></i>Download Transcript
        </a>
    </div>
</div>
@endif

@else
<div class="text-center py-12">
    <i class="fas fa-chart-line text-4xl text-gray-400 mb-4"></i>
    <p class="text-gray-500 text-lg">No results available</p>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('results.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
        Add First Result
    </a>
    @endif
</div>
@endif
@endsection