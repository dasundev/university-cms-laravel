@extends('layouts.app')

@section('title', 'Result Details - University Course Management')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Result Details</h1>
                    <p class="text-gray-600">Detailed view of academic result</p>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('results.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Results
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('results.edit', $result) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Result
                        </a>
                    @endif
                </div>
            </div>

            <!-- Grade Display -->
            <div class="text-center mb-8 bg-gray-50 rounded-lg p-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full mb-4
                @if(in_array($result->grade, ['A+', 'A', 'A-'])) bg-green-100
                @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) bg-blue-100
                @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) bg-yellow-100
                @else bg-red-100 @endif">
                <span class="text-3xl font-bold
                    @if(in_array($result->grade, ['A+', 'A', 'A-'])) text-green-800
                    @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) text-blue-800
                    @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) text-yellow-800
                    @else text-red-800 @endif">
                    {{ $result->grade }}
                </span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Final Grade</h2>
                <p class="text-gray-600">{{ $result->points }}/100 Points • {{ $result->gpa_points }} GPA Points</p>
            </div>

            <!-- Student and Course Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Student Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Student Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $result->user->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-id-card text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Student ID</p>
                                <p class="font-medium">{{ $result->user->student_id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $result->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Course Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-book text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Course Code</p>
                                <p class="font-medium">{{ $result->course->code }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Course Name</p>
                                <p class="font-medium">{{ $result->course->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-user-tie text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Instructor</p>
                                <p class="font-medium">{{ $result->course->instructor }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-star text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Credits</p>
                                <p class="font-medium">{{ $result->course->credits }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Semester</p>
                                <p class="font-medium">{{ $result->course->semester }} {{ $result->course->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Result Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-2xl font-bold text-blue-600">{{ $result->grade }}</p>
                            <p class="text-sm text-gray-600">Letter Grade</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-2xl font-bold text-green-600">{{ $result->points }}</p>
                            <p class="text-sm text-gray-600">Points (out of 100)</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-2xl font-bold text-purple-600">{{ $result->gpa_points }}</p>
                            <p class="text-sm text-gray-600">GPA Points</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-2xl font-bold text-orange-600">{{ $result->course->credits }}</p>
                            <p class="text-sm text-gray-600">Credit Hours</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Exam Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Exam Information</h3>
                    <div class="space-y-3">
                        @if($result->exam_date)
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-gray-400 w-5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Exam Date</p>
                                    <p class="font-medium">{{ $result->exam_date->format('F d, Y') }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Result Published</p>
                                <p class="font-medium">{{ $result->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>

                        @if($result->updated_at != $result->created_at)
                            <div class="flex items-center">
                                <i class="fas fa-edit text-gray-400 w-5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Last Updated</p>
                                    <p class="font-medium">{{ $result->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Performance Analysis -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Performance Analysis</h3>
                    <div class="space-y-4">
                        <!-- Grade Performance Bar -->
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Performance Level</span>
                                <span>{{ $result->points }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-300
                                @if($result->points >= 90) bg-green-500
                                @elseif($result->points >= 80) bg-blue-500
                                @elseif($result->points >= 70) bg-yellow-500
                                @elseif($result->points >= 60) bg-orange-500
                                @else bg-red-500 @endif"
                                     style="width: {{ $result->points }}%"></div>
                            </div>
                        </div>

                        <!-- Grade Category -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Grade Category:</span>
                            <span class="font-medium
                            @if(in_array($result->grade, ['A+', 'A', 'A-'])) text-green-600
                            @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) text-blue-600
                            @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) text-yellow-600
                            @else text-red-600 @endif">
                            @if(in_array($result->grade, ['A+', 'A', 'A-'])) Excellent
                                @elseif(in_array($result->grade, ['B+', 'B', 'B-'])) Good
                                @elseif(in_array($result->grade, ['C+', 'C', 'C-'])) Satisfactory
                                @elseif(in_array($result->grade, ['D+', 'D'])) Below Average
                                @else Failed @endif
                        </span>
                        </div>

                        <!-- Pass/Fail Status -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($result->grade !== 'F') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($result->grade !== 'F') Passed @else Failed @endif
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            @if($result->remarks)
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Instructor Remarks</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $result->remarks }}</p>
                </div>
            @endif

            <!-- Grade Scale Reference -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Grade Scale Reference</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 text-sm">
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-green-600">A+, A</div>
                        <div class="text-gray-600">4.0</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-green-600">A-</div>
                        <div class="text-gray-600">3.7</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-blue-600">B+</div>
                        <div class="text-gray-600">3.3</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-blue-600">B</div>
                        <div class="text-gray-600">3.0</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-blue-600">B-</div>
                        <div class="text-gray-600">2.7</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-yellow-600">C+</div>
                        <div class="text-gray-600">2.3</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-yellow-600">C</div>
                        <div class="text-gray-600">2.0</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-yellow-600">C-</div>
                        <div class="text-gray-600">1.7</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-orange-600">D+</div>
                        <div class="text-gray-600">1.3</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-orange-600">D</div>
                        <div class="text-gray-600">1.0</div>
                    </div>
                    <div class="text-center p-2 bg-white rounded">
                        <div class="font-bold text-red-600">F</div>
                        <div class="text-gray-600">0.0</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('courses.show', $result->course) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-book mr-2"></i>View Course
                </a>
                <a href="{{ route('enrollments.show', $result->enrollment) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-user-graduate mr-2"></i>View Enrollment
                </a>
                @if(auth()->user()->isStudent())
                    <a href="{{ route('transcript') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>View Transcript
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
