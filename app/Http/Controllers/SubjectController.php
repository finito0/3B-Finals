<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Student $student, Request $request)
    {
        $subjects = $student->subjects();

        if ($request->has('remarks')) {
            $subjects->where('remarks', $request->remarks);
        }

        if ($request->has('sort')) {
            $subjects->orderBy($request->sort);
        }

        $subjects = $subjects->paginate($request->get('limit', 10));

        return response()->json([
            'metadata' => [
                'count' => $subjects->total(),
                'search' => $request->query(),
                'limit' => $subjects->perPage(),
                'offset' => $subjects->currentPage(),
                'fields' => $request->only(['remarks']),
            ],
            'subjects' => $subjects->items(),
        ]);
    }

    public function store(Student $student, Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'instructor' => 'required|string',
            'schedule' => 'required|string',
            'prelims' => 'required|numeric',
            'midterms' => 'required|numeric',
            'pre_finals' => 'required|numeric',
            'finals' => 'required|numeric',
            'average_grade' => 'required|numeric',
            'remarks' => 'required|in:PASSED,FAILED',
            'date_taken' => 'required|date',
        ]);

        $subject = $student->subjects()->create($validated);

        return response()->json($subject, 201);
    }

    public function show(Student $student, Subject $subject)
    {
        return response()->json($subject);
    }

    public function update(Request $request, Student $student, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'string',
            'name' => 'string',
            'description' => 'string',
            'instructor' => 'string',
            'schedule' => 'string',
            'prelims' => 'numeric',
            'midterms' => 'numeric',
            'pre_finals' => 'numeric',
            'finals' => 'numeric',
            'average_grade' => 'numeric',
            'remarks' => 'in:PASSED,FAILED',
            'date_taken' => 'date',
        ]);

        $subject->update($validated);

        return response()->json($subject);
    }

    public function destroy(Student $student, Subject $subject)
    {
        $subject->delete();

        return response()->json(null, 204);
    }
}

