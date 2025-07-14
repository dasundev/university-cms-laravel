<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'code' => 'CS101',
                'name' => 'Introduction to Computer Science',
                'description' => 'Basic concepts of computer science and programming fundamentals.',
                'credits' => 3,
                'semester' => 'Fall',
                'year' => 2024,
                'instructor' => 'Dr. Alice Johnson',
                'capacity' => 30,
                'schedule' => 'MWF 9:00-10:00 AM',
                'room' => 'CS Building Room 101',
                'status' => 'active',
            ],
            [
                'code' => 'MATH201',
                'name' => 'Calculus II',
                'description' => 'Advanced calculus including integration techniques and series.',
                'credits' => 4,
                'semester' => 'Fall',
                'year' => 2024,
                'instructor' => 'Prof. Robert Brown',
                'capacity' => 25,
                'schedule' => 'TTh 11:00-12:30 PM',
                'room' => 'Math Building Room 205',
                'status' => 'active',
            ],
            [
                'code' => 'ENG102',
                'name' => 'English Composition',
                'description' => 'Advanced writing and composition skills for academic and professional contexts.',
                'credits' => 3,
                'semester' => 'Fall',
                'year' => 2024,
                'instructor' => 'Dr. Sarah Wilson',
                'capacity' => 20,
                'schedule' => 'MWF 2:00-3:00 PM',
                'room' => 'Liberal Arts Building Room 301',
                'status' => 'active',
            ],
            [
                'code' => 'PHYS201',
                'name' => 'Physics I',
                'description' => 'Mechanics, thermodynamics, and wave motion.',
                'credits' => 4,
                'semester' => 'Fall',
                'year' => 2024,
                'instructor' => 'Dr. Michael Davis',
                'capacity' => 35,
                'schedule' => 'MWF 10:00-11:00 AM, Lab: T 2:00-5:00 PM',
                'room' => 'Physics Building Room 150',
                'status' => 'active',
            ],
            [
                'code' => 'HIST101',
                'name' => 'World History',
                'description' => 'Survey of world civilizations from ancient times to present.',
                'credits' => 3,
                'semester' => 'Fall',
                'year' => 2024,
                'instructor' => 'Prof. Emily Taylor',
                'capacity' => 40,
                'schedule' => 'TTh 9:30-11:00 AM',
                'room' => 'Humanities Building Room 220',
                'status' => 'active',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}