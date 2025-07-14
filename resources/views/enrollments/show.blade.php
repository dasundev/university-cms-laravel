@extends('layouts.app')

@section('title', 'Enrollment Details - University Course Management')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Enrollment Details</h1>
                    <p class="text-gray-600">View enrollment information and course details</p>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('enrollments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Enrollments
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->id === $enrollment->user_id)
                        <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-trash mr-2"></i>Delete Enrollment
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Enrollment Status -->
            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <span class="text-lg font-medium text-gray-700">Status:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($enrollment->status === 'enrolled') bg-green-100 text-green-800
                    @elseif($enrollment->status === 'dropped') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($enrollment->status) }}
                </span>
                </div>
            </div>

            <!-- Student Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Student Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $enrollment->user->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-id-card text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Student ID</p>
                                <p class="font-medium">{{ $enrollment->user->student_id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $enrollment->user->email }}</p>
                            </div>
                        </div>

                        @if($enrollment->user->phone)
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <p class="font-medium">{{ $enrollment->user->phone }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Course Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Course Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-book text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Course Code</p>
                                <p class="font-medium">{{ $enrollment->course->code }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Course Name</p>
                                <p class="font-medium">{{ $enrollment->course->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-user-tie text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Instructor</p>
                                <p class="font-medium">{{ $enrollment->course->instructor }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-star text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Credits</p>
                                <p class="font-medium">{{ $enrollment->course->credits }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Semester</p>
                                <p class="font-medium">{{ $enrollment->course->semester }} {{ $enrollment->course->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollment Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Enrollment Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-plus text-gray-400 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Enrollment Date</p>
                            <p class="font-medium">{{ $enrollment->enrollment_date->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Schedule</p>
                            <p class="font-medium">{{ $enrollment->course->schedule ?? 'TBA' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Room</p>
                            <p class="font-medium">{{ $enrollment->course->room ?? 'TBA' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-gray-400 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Course Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($enrollment->course->status === 'active') bg-green-100 text-green-800
                            @elseif($enrollment->course->status === 'inactive') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($enrollment->course->status) }}
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Description -->
            @if($enrollment->course->description)
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Course Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $enrollment->course->description }}</p>
                </div>
            @endif

            <!-- Result Information -->
            @if($enrollment->result)
                <div class="bg-blue-50 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Course Result</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $enrollment->result->grade }}</p>
                            <p class="text-sm text-gray-600">Final Grade</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $enrollment->result->points }}/100</p>
                            <p class="text-sm text-gray-600">Points Scored</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ $enrollment->result->gpa_points }}</p>
                            <p class="text-sm text-gray-600">GPA Points</p>
                        </div>
                    </div>

                    @if($enrollment->result->remarks)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-1">Remarks:</p>
                            <p class="text-gray-800">{{ $enrollment->result->remarks }}</p>
                        </div>
                    @endif

                    @if($enrollment->result->exam_date)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-1">Exam Date:</p>
                            <p class="text-gray-800">{{ $enrollment->result->exam_date->format('F d, Y') }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-yellow-50 rounded-lg p-6 text-center">
                    <i class="fas fa-clock text-yellow-600 text-3xl mb-2"></i>
                    <p class="text-yellow-800 font-medium">Result Pending</p>
                    <p class="text-yellow-600 text-sm">The result for this course has not been published yet.</p>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('courses.show', $enrollment->course) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-book mr-2"></i>View Course Details
                </a>
                @if(auth()->user()->isStudent() && $enrollment->result)
                    <a href="{{ route('results.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-chart-line mr-2"></i>View All Results
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
