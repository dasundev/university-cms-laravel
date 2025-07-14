@extends('layouts.app')

@section('title', 'Edit Result - University Course Management')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Student Result</h1>
                <p class="text-gray-600">Update grade and performance information</p>
            </div>

            <!-- Current Result Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Student:</span>
                        <span class="text-gray-900">{{ $result->user->name }} ({{ $result->user->student_id }})</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Course:</span>
                        <span class="text-gray-900">{{ $result->course->code }} - {{ $result->course->name }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('results.update', $result) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                        <select id="grade" name="grade" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Grade</option>
                            <option value="A+" {{ old('grade', $result->grade) == 'A+' ? 'selected' : '' }}>A+ (Excellent)</option>
                            <option value="A" {{ old('grade', $result->grade) == 'A' ? 'selected' : '' }}>A (Excellent)</option>
                            <option value="A-" {{ old('grade', $result->grade) == 'A-' ? 'selected' : '' }}>A- (Very Good)</option>
                            <option value="B+" {{ old('grade', $result->grade) == 'B+' ? 'selected' : '' }}>B+ (Good)</option>
                            <option value="B" {{ old('grade', $result->grade) == 'B' ? 'selected' : '' }}>B (Good)</option>
                            <option value="B-" {{ old('grade', $result->grade) == 'B-' ? 'selected' : '' }}>B- (Above Average)</option>
                            <option value="C+" {{ old('grade', $result->grade) == 'C+' ? 'selected' : '' }}>C+ (Average)</option>
                            <option value="C" {{ old('grade', $result->grade) == 'C' ? 'selected' : '' }}>C (Average)</option>
                            <option value="C-" {{ old('grade', $result->grade) == 'C-' ? 'selected' : '' }}>C- (Below Average)</option>
                            <option value="D+" {{ old('grade', $result->grade) == 'D+' ? 'selected' : '' }}>D+ (Poor)</option>
                            <option value="D" {{ old('grade', $result->grade) == 'D' ? 'selected' : '' }}>D (Poor)</option>
                            <option value="F" {{ old('grade', $result->grade) == 'F' ? 'selected' : '' }}>F (Fail)</option>
                        </select>
                        @error('grade')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Points (0-100)</label>
                        <input type="number" id="points" name="points" value="{{ old('points', $result->points) }}"
                               min="0" max="100" step="0.01" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('points')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">Exam Date</label>
                    <input type="date" id="exam_date" name="exam_date"
                           value="{{ old('exam_date', $result->exam_date ? $result->exam_date->format('Y-m-d') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('exam_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="4"
                              placeholder="Optional comments about the student's performance..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('remarks', $result->remarks) }}</textarea>
                    @error('remarks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grade Scale Reference -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Grade Scale Reference</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">
                        <div class="flex justify-between">
                            <span>A+, A:</span>
                            <span class="font-medium">4.0 (90-100)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>A-:</span>
                            <span class="font-medium">3.7 (87-89)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>B+:</span>
                            <span class="font-medium">3.3 (83-86)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>B:</span>
                            <span class="font-medium">3.0 (80-82)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>B-:</span>
                            <span class="font-medium">2.7 (77-79)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>C+:</span>
                            <span class="font-medium">2.3 (73-76)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>C:</span>
                            <span class="font-medium">2.0 (70-72)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>C-:</span>
                            <span class="font-medium">1.7 (67-69)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>D+:</span>
                            <span class="font-medium">1.3 (63-66)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>D:</span>
                            <span class="font-medium">1.0 (60-62)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>F:</span>
                            <span class="font-medium">0.0 (0-59)</span>
                        </div>
                    </div>
                </div>

                <!-- Current vs New Comparison -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Current Result</h3>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div class="text-center">
                            <div class="font-bold text-lg text-blue-600">{{ $result->grade }}</div>
                            <div class="text-gray-600">Current Grade</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-lg text-green-600">{{ $result->points }}</div>
                            <div class="text-gray-600">Current Points</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-lg text-purple-600">{{ $result->gpa_points }}</div>
                            <div class="text-gray-600">Current GPA Points</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('results.show', $result) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Update Result
                    </button>
                </div>
            </form>
        </div>

        <!-- Warning Notice -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        Updating this result will affect the student's GPA calculation. Please ensure all information is accurate before saving changes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-suggest points based on grade selection
        document.getElementById('grade').addEventListener('change', function() {
            const grade = this.value;
            const pointsInput = document.getElementById('points');

            const gradeToPoints = {
                'A+': 95, 'A': 92, 'A-': 88,
                'B+': 85, 'B': 81, 'B-': 78,
                'C+': 75, 'C': 71, 'C-': 68,
                'D+': 65, 'D': 61, 'F': 45
            };

            if (gradeToPoints[grade] && !pointsInput.value) {
                pointsInput.value = gradeToPoints[grade];
            }
        });
    </script>
@endsection
