<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EnrollmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $enrollments = Enrollment::with(['user', 'course'])
                ->latest()
                ->paginate(15);
        } else {
            $enrollments = Auth::user()->enrollments()
                ->with('course')
                ->latest()
                ->paginate(15);
        }

        return view('enrollments.index', compact('enrollments'));
    }

    public function show(Enrollment $enrollment)
    {
        Gate::authorize('view', $enrollment);

        $enrollment->load(['user', 'course', 'result']);

        return view('enrollments.show', compact('enrollment'));
    }

    public function destroy(Enrollment $enrollment)
    {
        Gate::authorize('delete', $enrollment);

        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}
