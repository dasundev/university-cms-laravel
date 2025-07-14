@extends('layouts.app')

@section('title', 'Admin Dashboard - University Course Management')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Students</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-book text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-play text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Active Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_courses'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Enrollments</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_enrollments'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Enrollments -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Recent Enrollments</h2>
            <a href="{{ route('enrollments.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">View All</a>
        </div>
        
        <div class="space-y-4">
            @forelse($recent_enrollments as $enrollment)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">{{ $enrollment->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $enrollment->course->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $enrollment->enrollment_date->format('M d, Y') }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No recent enrollments</p>
            @endforelse
        </div>
    </div>

    <!-- Course Overview -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Course Overview</h2>
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">View All</a>
        </div>
        
        <div class="space-y-4">
            @forelse($courses as $course)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">{{ $course->code }}</p>
                    <p class="text-sm text-gray-600">{{ $course->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $course->enrollments_count }}/{{ $course->capacity }} enrolled</p>
                    <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($course->enrollments_count / $course->capacity) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No courses available</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('courses.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
            <i class="fas fa-plus-circle text-blue-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-blue-900">Add New Course</p>
                <p class="text-sm text-blue-600">Create a new course offering</p>
            </div>
        </a>
        
        <a href="{{ route('results.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
            <i class="fas fa-chart-line text-green-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-green-900">Add Result</p>
                <p class="text-sm text-green-600">Record student grades</p>
            </div>
        </a>
        
        <a href="{{ route('enrollments.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
            <i class="fas fa-list text-purple-600 text-2xl mr-3"></i>
            <div>
                <p class="font-medium text-purple-900">Manage Enrollments</p>
                <p class="text-sm text-purple-600">View and manage student enrollments</p>
            </div>
        </a>
    </div>
</div>
@endsection