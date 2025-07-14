@extends('layouts.app')

@section('title', 'Courses - University Course Management')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Course Catalog</h1>
        <p class="text-gray-600">Browse and manage course offerings</p>
    </div>
    
    @if(auth()->user()->isAdmin())
    <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
        <i class="fas fa-plus mr-2"></i>Add New Course
    </a>
    @endif
</div>

<!-- Course Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($courses as $course)
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $course->code }}</h3>
                <p class="text-gray-600">{{ $course->name }}</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                @if($course->status === 'active') bg-green-100 text-green-800
                @elseif($course->status === 'inactive') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($course->status) }}
            </span>
        </div>

        <div class="space-y-2 mb-4">
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-user-tie w-4 mr-2"></i>
                <span>{{ $course->instructor }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-calendar w-4 mr-2"></i>
                <span>{{ $course->semester }} {{ $course->year }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-clock w-4 mr-2"></i>
                <span>{{ $course->schedule ?? 'TBA' }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                <span>{{ $course->room ?? 'TBA' }}</span>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <span class="text-sm font-medium text-gray-700">{{ $course->credits }} Credits</span>
            <span class="text-sm text-gray-600">{{ $course->enrolled_count }}/{{ $course->capacity }} enrolled</span>
        </div>

        <!-- Enrollment Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($course->enrolled_count / $course->capacity) * 100 }}%"></div>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-500 font-medium">
                View Details
            </a>
            
            @if(auth()->user()->isAdmin())
            <div class="flex space-x-2">
                <a href="{{ route('courses.edit', $course) }}" class="text-yellow-600 hover:text-yellow-500">
                    <i class="fas fa-edit"></i>
                </a>
                <form method="POST" action="{{ route('courses.destroy', $course) }}" class="inline" 
                      onsubmit="return confirm('Are you sure you want to delete this course?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-500">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fas fa-book text-4xl text-gray-400 mb-4"></i>
        <p class="text-gray-500 text-lg">No courses available</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('courses.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            Add First Course
        </a>
        @endif
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $courses->links() }}
</div>
@endsection