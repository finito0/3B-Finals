<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query();

        if ($request->has('year')) {
            $students->where('year', $request->year);
        }
        if ($request->has('course')) {
            $students->where('course', $request->course);
        }
        if ($request->has('section')) {
            $students->where('section', $request->section);
        }

        if ($request->has('sort')) {
            $students->orderBy($request->sort);
        }

        $students = $students->paginate($request->get('limit', 10));

        return response()->json([
            'metadata' => [
                'count' => $students->total(),
                'search' => $request->query(),
                'limit' => $students->perPage(),
                'offset' => $students->currentPage(),
                'fields' => $request->only(['year', 'course', 'section']),
            ],
            'students' => $students->items(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'birthdate' => 'required|date',
            'sex' => 'required|in:MALE,FEMALE',
            'address' => 'required|string',
            'year' => 'required|integer',
            'course' => 'required|string',
            'section' => 'required|string',
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'birthdate' => 'date',
            'sex' => 'in:MALE,FEMALE',
            'address' => 'string',
            'year' => 'integer',
            'course' => 'string',
            'section' => 'string',
        ]);

        $student->update($validated);

        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(null, 204);
    }
}

