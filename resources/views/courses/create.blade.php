@extends('layouts.app')

@section('title', 'Create Course - University Course Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Create New Course</h1>
            <p class="text-gray-600">Add a new course to the catalog</p>
        </div>

        <form method="POST" action="{{ route('courses.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Course Code</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="credits" class="block text-sm font-medium text-gray-700 mb-2">Credits</label>
                    <select id="credits" name="credits" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Credits</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('credits') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('credits')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Course Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                    <select id="semester" name="semester" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Semester</option>
                        <option value="Fall" {{ old('semester') == 'Fall' ? 'selected' : '' }}>Fall</option>
                        <option value="Spring" {{ old('semester') == 'Spring' ? 'selected' : '' }}>Spring</option>
                        <option value="Summer" {{ old('semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2024" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="instructor" class="block text-sm font-medium text-gray-700 mb-2">Instructor</label>
                <input type="text" id="instructor" name="instructor" value="{{ old('instructor') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('instructor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700 mb-2">Room</label>
                    <input type="text" id="room" name="room" value="{{ old('room') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('room')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="schedule" class="block text-sm font-medium text-gray-700 mb-2">Schedule</label>
                <input type="text" id="schedule" name="schedule" value="{{ old('schedule') }}" 
                       placeholder="e.g., MWF 9:00-10:00 AM"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('schedule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Create Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection