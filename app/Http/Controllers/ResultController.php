<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ResultController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $results = Result::with(['user', 'course'])
                ->latest()
                ->paginate(15);
        } else {
            $results = Auth::user()->results()
                ->with('course')
                ->latest()
                ->paginate(15);
        }

        return view('results.index', compact('results'));
    }

    public function create()
    {
        Gate::authorize('create', Result::class);

        $enrollments = Enrollment::with(['user', 'course'])
            ->whereDoesntHave('result')
            ->get();

        return view('results.create', compact('enrollments'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Result::class);

        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
            'points' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string',
            'exam_date' => 'nullable|date',
        ]);

        $enrollment = Enrollment::findOrFail($request->enrollment_id);

        Result::create([
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'enrollment_id' => $enrollment->id,
            'grade' => $request->grade,
            'points' => $request->points,
            'remarks' => $request->remarks,
            'exam_date' => $request->exam_date,
        ]);

        return redirect()->route('results.index')->with('success', 'Result created successfully.');
    }

    public function show(Result $result)
    {
        Gate::authorize('view', $result);

        $result->load(['user', 'course', 'enrollment']);

        return view('results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        Gate::authorize('update', $result);

        return view('results.edit', compact('result'));
    }

    public function update(Request $request, Result $result)
    {
        Gate::authorize('update', $result);

        $request->validate([
            'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
            'points' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string',
            'exam_date' => 'nullable|date',
        ]);

        $result->update($request->only(['grade', 'points', 'remarks', 'exam_date']));

        return redirect()->route('results.index')->with('success', 'Result updated successfully.');
    }

    public function destroy(Result $result)
    {
        Gate::authorize('delete', $result);

        $result->delete();

        return redirect()->route('results.index')->with('success', 'Result deleted successfully.');
    }

    public function transcript()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            abort(403, 'Only students can view transcripts.');
        }

        $results = $user->results()->with('course')->get();
        $gpa = $this->calculateGPA($results);

        return view('results.transcript', compact('results', 'gpa', 'user'));
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
