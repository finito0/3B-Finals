<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        $grades = [
            'prelims' => $this->faker->randomFloat(2, 1, 5),
            'midterms' => $this->faker->randomFloat(2, 1, 5),
            'pre_finals' => $this->faker->randomFloat(2, 1, 5),
            'finals' => $this->faker->randomFloat(2, 1, 5),
        ];
        $average_grade = array_sum($grades) / count($grades);
        $remarks = $average_grade >= 3.0 ? 'PASSED' : 'FAILED';

        return [
            'subject_code' => Str::upper(Str::random(5)),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'instructor' => $this->faker->name,
            'schedule' => $this->faker->randomElement(['MW 7AM-12PM', 'TTh 1PM-4PM']),
            'prelims' => $grades['prelims'],
            'midterms' => $grades['midterms'],
            'pre_finals' => $grades['pre_finals'],
            'finals' => $grades['finals'],
            'average_grade' => $average_grade,
            'remarks' => $remarks,
            'date_taken' => $this->faker->date('Y-m-d'),
        ];
    }
}

