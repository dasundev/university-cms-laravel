<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load('enrollments.user');
        $isEnrolled = Auth::check() && $course->enrollments()->where('user_id', Auth::id())->exists();

        return view('courses.show', compact('course', 'isEnrolled'));
    }

    public function create()
    {
        Gate::authorize('create', Course::class);
        return view('courses.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Course::class);

        $request->validate([
            'code' => 'required|string|unique:courses',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:Fall,Spring,Summer',
            'year' => 'required|integer|min:2024',
            'instructor' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'schedule' => 'nullable|string',
            'room' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        Gate::authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        Gate::authorize('update', $course);

        $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:Fall,Spring,Summer',
            'year' => 'required|integer|min:2024',
            'instructor' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'schedule' => 'nullable|string',
            'room' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return redirect()->back()->with('error', 'Only students can enroll in courses.');
        }

        if (!$course->isAvailable()) {
            return redirect()->back()->with('error', 'Course is not available for enrollment.');
        }

        if ($course->enrollments()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'status' => 'enrolled',
        ]);

        return redirect()->back()->with('success', 'Successfully enrolled in the course.');
    }

    public function drop(Course $course)
    {
        $user = Auth::user();

        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        $enrollment->update(['status' => 'dropped']);

        return redirect()->back()->with('success', 'Successfully dropped from the course.');
    }
}
