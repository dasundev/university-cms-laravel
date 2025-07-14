@extends('layouts.app')

@section('title', 'Academic Transcript - University Course Management')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <!-- Header -->
        <div class="text-center mb-8 border-b pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">OFFICIAL ACADEMIC TRANSCRIPT</h1>
            <p class="text-lg text-gray-600">University Course Management System</p>
            <p class="text-sm text-gray-500">Generated on {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Student Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Student Information</h2>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Name:</span>
                        <span class="text-gray-900">{{ $user->name }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Student ID:</span>
                        <span class="text-gray-900">{{ $user->student_id }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Email:</span>
                        <span class="text-gray-900">{{ $user->email }}</span>
                    </div>
                    @if($user->date_of_birth)
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Date of Birth:</span>
                        <span class="text-gray-900">{{ $user->date_of_birth->format('F d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Academic Summary</h2>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Total Courses:</span>
                        <span class="text-gray-900">{{ $results->count() }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Total Credits:</span>
                        <span class="text-gray-900">{{ $results->sum(function($result) { return $result->course->credits; }) }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-700 w-32">Cumulative GPA:</span>
                        <span class="text-gray-900 font-bold text-lg">{{ $gpa }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Record -->
        @if($results->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Academic Record</h2>
            
            @php
                $resultsBySemester = $results->groupBy(function($result) {
                    return $result->course->semester . ' ' . $result->course->year;
                });
            @endphp

            @foreach($resultsBySemester as $semester => $semesterResults)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 bg-gray-100 px-4 py-2 rounded">{{ $semester }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Course Code</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Course Name</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-b">Credits</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-b">Grade</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-b">Points</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-b">GPA Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semesterResults as $result)
                            <tr class="border-b">
                                <td class="px-4 py-2 font-medium">{{ $result->course->code }}</td>
                                <td class="px-4 py-2">{{ $result->course->name }}</td>
                                <td class="px-4 py-2 text-center">{{ $result->course->credits }}</td>
                                <td class="px-4 py-2 text-center font-medium">{{ $result->grade }}</td>
                                <td class="px-4 py-2 text-center">{{ $result->points }}</td>
                                <td class="px-4 py-2 text-center">{{ $result->gpa_points }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-4 py-2 font-medium">Semester Totals:</td>
                                <td class="px-4 py-2 text-center font-medium">{{ $semesterResults->sum(function($result) { return $result->course->credits; }) }}</td>
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2 text-center font-medium">
                                    @php
                                        $semesterTotalPoints = 0;
                                        $semesterTotalCredits = 0;
                                        foreach($semesterResults as $result) {
                                            $semesterTotalPoints += $result->gpa_points * $result->course->credits;
                                            $semesterTotalCredits += $result->course->credits;
                                        }
                                        $semesterGPA = $semesterTotalCredits > 0 ? round($semesterTotalPoints / $semesterTotalCredits, 2) : 0;
                                    @endphp
                                    {{ $semesterGPA }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Grade Scale -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Grade Scale</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="flex justify-between">
                    <span>A+, A:</span>
                    <span>4.0</span>
                </div>
                <div class="flex justify-between">
                    <span>A-:</span>
                    <span>3.7</span>
                </div>
                <div class="flex justify-between">
                    <span>B+:</span>
                    <span>3.3</span>
                </div>
                <div class="flex justify-between">
                    <span>B:</span>
                    <span>3.0</span>
                </div>
                <div class="flex justify-between">
                    <span>B-:</span>
                    <span>2.7</span>
                </div>
                <div class="flex justify-between">
                    <span>C+:</span>
                    <span>2.3</span>
                </div>
                <div class="flex justify-between">
                    <span>C:</span>
                    <span>2.0</span>
                </div>
                <div class="flex justify-between">
                    <span>C-:</span>
                    <span>1.7</span>
                </div>
                <div class="flex justify-between">
                    <span>D+:</span>
                    <span>1.3</span>
                </div>
                <div class="flex justify-between">
                    <span>D:</span>
                    <span>1.0</span>
                </div>
                <div class="flex justify-between">
                    <span>F:</span>
                    <span>0.0</span>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-8">
            <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">No academic records available</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="border-t pt-6 mt-8 text-center text-sm text-gray-500">
            <p>This is an official transcript generated by the University Course Management System.</p>
            <p>For verification purposes, please contact the registrar's office.</p>
        </div>
    </div>

    <!-- Print Button -->
    <div class="text-center mb-8">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
            <i class="fas fa-print mr-2"></i>Print Transcript
        </button>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .max-w-4xl, .max-w-4xl * {
        visibility: visible;
    }
    .max-w-4xl {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    nav, footer, button {
        display: none !important;
    }
}
</style>
@endsection