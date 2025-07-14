@extends('layouts.app')

@section('title', 'Enrollments - University Course Management')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if(auth()->user()->isAdmin())
                    All Enrollments
                @else
                    My Enrollments
                @endif
            </h1>
            <p class="text-gray-600">Manage course enrollments</p>
        </div>
    </div>

    @if($enrollments->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        @if(auth()->user()->isAdmin())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50">
                            @if(auth()->user()->isAdmin())
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $enrollment->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $enrollment->user->student_id }}</div>
                                    </div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $enrollment->course->code }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->course->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $enrollment->course->instructor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $enrollment->course->credits }}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('enrollments.show', $enrollment) }}" class="text-blue-600 hover:text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('courses.show', $enrollment->course) }}" class="text-green-600 hover:text-green-500">
                                        <i class="fas fa-book"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $enrollment->user_id)
                                        <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-500">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $enrollments->links() }}
        </div>

        @if(auth()->user()->isStudent())
            <!-- Enrollment Summary -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Enrollment Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $enrollments->where('status', 'enrolled')->count() }}</p>
                        <p class="text-sm text-gray-600">Active Enrollments</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $enrollments->where('status', 'completed')->count() }}</p>
                        <p class="text-sm text-gray-600">Completed Courses</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $enrollments->sum(function($enrollment) { return $enrollment->course->credits; }) }}</p>
                        <p class="text-sm text-gray-600">Total Credits</p>
                    </div>
                </div>
            </div>
        @endif

    @else
        <div class="text-center py-12">
            <i class="fas fa-user-graduate text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">No enrollments found</p>
            @if(auth()->user()->isStudent())
                <a href="{{ route('courses.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Browse Courses
                </a>
            @endif
        </div>
    @endif
@endsection
