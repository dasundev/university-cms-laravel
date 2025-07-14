@extends('layouts.app')

@section('title', 'Add Result - University Course Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Add Student Result</h1>
            <p class="text-gray-600">Record a grade for a student's course</p>
        </div>

        <form method="POST" action="{{ route('results.store') }}">
            @csrf
            
            <div class="mb-6">
                <label for="enrollment_id" class="block text-sm font-medium text-gray-700 mb-2">Student & Course</label>
                <select id="enrollment_id" name="enrollment_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Student & Course</option>
                    @foreach($enrollments as $enrollment)
                        <option value="{{ $enrollment->id }}" {{ old('enrollment_id') == $enrollment->id ? 'selected' : '' }}>
                            {{ $enrollment->user->name }} ({{ $enrollment->user->student_id }}) - {{ $enrollment->course->code }} {{ $enrollment->course->name }}
                        </option>
                    @endforeach
                </select>
                @error('enrollment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                    <select id="grade" name="grade" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Grade</option>
                        <option value="A+" {{ old('grade') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="A-" {{ old('grade') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('grade') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="B-" {{ old('grade') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="C+" {{ old('grade') == 'C+' ? 'selected' : '' }}>C+</option>
                        <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="C-" {{ old('grade') == 'C-' ? 'selected' : '' }}>C-</option>
                        <option value="D+" {{ old('grade') == 'D+' ? 'selected' : '' }}>D+</option>
                        <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D</option>
                        <option value="F" {{ old('grade') == 'F' ? 'selected' : '' }}>F</option>
                    </select>
                    @error('grade')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Points (0-100)</label>
                    <input type="number" id="points" name="points" value="{{ old('points') }}" min="0" max="100" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('points')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">Exam Date</label>
                <input type="date" id="exam_date" name="exam_date" value="{{ old('exam_date') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('exam_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea id="remarks" name="remarks" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('results.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Add Result
                </button>
            </div>
        </form>
    </div>
</div>
@endsection