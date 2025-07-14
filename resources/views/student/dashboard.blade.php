@extends('layouts.app')

@section('title', 'Student Dashboard - University Course Management')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Student Dashboard</h1>
    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}! ({{ auth()->user()->student_id }})</p>
</div>

<!-- Academic Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-book-open text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Enrolled Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $enrollments->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Completed Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $results->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-star text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Current GPA</p>
                <p class="text-2xl font-bold text-gray-900">{{ $gpa }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Current Enrollments -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Current Enrollments</h2>
            <a href="{{ route('enrollments.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">View All</a>
        </div>
        
        <div class="space-y-4">
            @forelse($enrollments->take(5) as $enrollment)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">{{ $enrollment->course->code }}</p>
                    <p class="text-sm text-gray-600">{{ $enrollment->course->name }}</p>
                    <p class="text-xs text-gray-500">{{ $enrollment->course->instructor }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $enrollment->course->credits }} Credits
                    </span>
                    <p class="text-xs text-gray-500 mt-1">{{ $enrollment->course->schedule }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No current enrollments</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Results -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Recent Results</h2>
            <a href="{{ route('results.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">View All</a>
        </div>
        
        <div class="space-y-4">
            @forelse($results->take(5) as $result)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">{{ $result->course->code }}</p>
                    <p class="text-sm text-gray-600">{{ $result->course->name }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if(in_array($result->grade, ['A+', 'A', 'A-'])) bg-green-100 text-green-800
                        @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) bg-blue-100 text-blue-800
                        @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $result->grade }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">{{ $result->points }}/100</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No results available</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Available Courses -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Available Courses</h2>
        <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">View All</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($available_courses as $course)
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-medium text-gray-900">{{ $course->code }}</h3>
                <span class="text-xs text-gray-500">{{ $course->credits }} Credits</span>
            </div>
            <p class="text-sm text-gray-600 mb-2">{{ $course->name }}</p>
            <p class="text-xs text-gray-500 mb-3">{{ $course->instructor }}</p>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500">{{ $course->enrolled_count }}/{{ $course->capacity }} enrolled</span>
                <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-500 text-sm">View Details</a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-4">
            <p class="text-gray-500">No available courses at the moment</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('courses.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
            <i class="fas fa-search text-blue-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-blue-900">Browse Courses</p>
                <p class="text-sm text-blue-600">Find and enroll in courses</p>
            </div>
        </a>
        
        <a href="{{ route('transcript') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
            <i class="fas fa-file-alt text-green-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-green-900">View Transcript</p>
                <p class="text-sm text-green-600">Download academic transcript</p>
            </div>
        </a>
        
        <a href="{{ route('results.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
            <i class="fas fa-chart-bar text-purple-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-purple-900">View Results</p>
                <p class="text-sm text-purple-600">Check your grades and performance</p>
            </div>
        </a>
    </div>
</div>
@endsection