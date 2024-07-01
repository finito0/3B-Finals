<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Create students
        $students = Student::factory()->count(10)->create();

        // Create subjects for each student
        $students->each(function ($student) {
            Subject::factory()->count(5)->create(['student_id' => $student->id]);
        });
    }
}

