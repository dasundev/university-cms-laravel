<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->studentDashboard();
    }

    private function adminDashboard()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('status', 'active')->count(),
            'total_enrollments' => Enrollment::count(),
        ];

        $recent_enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $courses = Course::withCount('enrollments')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_enrollments', 'courses'));
    }

    private function studentDashboard()
    {
        $user = Auth::user();
        
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->get();

        $results = $user->results()
            ->with('course')
            ->latest()
            ->get();

        $gpa = $this->calculateGPA($results);

        $available_courses = Course::where('status', 'active')
            ->whereNotIn('id', $enrollments->pluck('course_id'))
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('enrollments', 'results', 'gpa', 'available_courses'));
    }

    private function calculateGPA($results)
    {
        if ($results->isEmpty()) {
            return 0;
        }

        $totalPoints = 0;
        $totalCredits = 0;

        foreach ($results as $result) {
            $totalPoints += $result->gpa_points * $result->course->credits;
            $totalCredits += $result->course->credits;
        }

        return $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
    }
}