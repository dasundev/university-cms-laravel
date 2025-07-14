@extends('layouts.app')

@section('title', $course->name . ' - University Course Management')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Course Header -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $course->code }}</h1>
                <h2 class="text-xl text-gray-700 mb-4">{{ $course->name }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if($course->status === 'active') bg-green-100 text-green-800
                    @elseif($course->status === 'inactive') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($course->status) }}
                </span>
            </div>
            
            @if(auth()->user()->isStudent())
                @if($isEnrolled)
                <form method="POST" action="{{ route('courses.drop', $course) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors"
                            onclick="return confirm('Are you sure you want to drop this course?')">
                        <i class="fas fa-times mr-2"></i>Drop Course
                    </button>
                </form>
                @elseif($course->isAvailable())
                <form method="POST" action="{{ route('courses.enroll', $course) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Enroll Now
                    </button>
                </form>
                @else
                <button disabled class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                    <i class="fas fa-lock mr-2"></i>Course Full
                </button>
                @endif
            @endif

            @if(auth()->user()->isAdmin())
            <div class="flex space-x-2">
                <a href="{{ route('courses.edit', $course) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Course
                </a>
            </div>
            @endif
        </div>

        <!-- Course Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-user-tie text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Instructor</p>
                        <p class="font-medium">{{ $course->instructor }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-calendar text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Semester</p>
                        <p class="font-medium">{{ $course->semester }} {{ $course->year }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-star text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Credits</p>
                        <p class="font-medium">{{ $course->credits }} Credits</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Schedule</p>
                        <p class="font-medium">{{ $course->schedule ?? 'TBA' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Room</p>
                        <p class="font-medium">{{ $course->room ?? 'TBA' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-users text-gray-400 w-5 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Enrollment</p>
                        <p class="font-medium">{{ $course->enrolled_count }}/{{ $course->capacity }} students</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollment Progress -->
        <div class="mt-6">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Enrollment Progress</span>
                <span>{{ round(($course->enrolled_count / $course->capacity) * 100) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" 
                     style="width: {{ ($course->enrolled_count / $course->capacity) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Course Description -->
    @if($course->description)
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Course Description</h3>
        <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
    </div>
    @endif

    <!-- Enrolled Students (Admin Only) -->
    @if(auth()->user()->isAdmin() && $course->enrollments->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Enrolled Students ({{ $course->enrollments->count() }})</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($course->enrollments as $enrollment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $enrollment->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $enrollment->user->student_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $enrollment->user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $enrollment->enrollment_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($enrollment->status === 'enrolled') bg-green-100 text-green-800
                                @elseif($enrollment->status === 'dropped') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection