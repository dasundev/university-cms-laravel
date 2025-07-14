<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@university.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample students
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@student.university.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'STU001',
            'phone' => '+1234567890',
            'address' => '123 Student Street, University City',
            'date_of_birth' => '2000-05-15',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@student.university.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'STU002',
            'phone' => '+1234567891',
            'address' => '456 Campus Avenue, University City',
            'date_of_birth' => '1999-08-22',
        ]);

        User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike.johnson@student.university.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'STU003',
            'phone' => '+1234567892',
            'address' => '789 College Road, University City',
            'date_of_birth' => '2001-02-10',
        ]);
    }
}