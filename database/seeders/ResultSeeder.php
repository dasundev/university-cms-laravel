<?php

namespace Database\Seeders;

use App\Models\Result;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::all();
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'];
        
        // Create results for some enrollments (simulating completed courses)
        foreach ($enrollments->random($enrollments->count() * 0.6) as $enrollment) {
            $grade = $grades[array_rand($grades)];
            $points = $this->getPointsForGrade($grade);
            
            Result::create([
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
                'enrollment_id' => $enrollment->id,
                'grade' => $grade,
                'points' => $points,
                'remarks' => $this->getRemarks($grade),
                'exam_date' => now()->subDays(rand(1, 60)),
            ]);
        }
    }

    private function getPointsForGrade($grade)
    {
        $gradePoints = [
            'A+' => rand(95, 100),
            'A' => rand(90, 94),
            'A-' => rand(87, 89),
            'B+' => rand(83, 86),
            'B' => rand(80, 82),
            'B-' => rand(77, 79),
            'C+' => rand(73, 76),
            'C' => rand(70, 72),
            'C-' => rand(67, 69),
            'D+' => rand(63, 66),
            'D' => rand(60, 62),
            'F' => rand(0, 59),
        ];

        return $gradePoints[$grade];
    }

    private function getRemarks($grade)
    {
        $remarks = [
            'A+' => 'Outstanding performance',
            'A' => 'Excellent work',
            'A-' => 'Very good performance',
            'B+' => 'Good work',
            'B' => 'Satisfactory performance',
            'B-' => 'Above average',
            'C+' => 'Average performance',
            'C' => 'Meets requirements',
            'C-' => 'Below average',
            'D+' => 'Poor performance',
            'D' => 'Barely passing',
            'F' => 'Failed to meet requirements',
        ];

        return $remarks[$grade];
    }
}