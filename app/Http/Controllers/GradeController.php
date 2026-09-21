<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    public function store(Request $request)
{
    $student = Grade::where('name', $request->input('name'))
        ->where('id_number', $request->input('id_number'))
        ->first();

    if ($student) {
        return back()->with('error', 'Student already exists.');
    }

    Grade::create([
        'name' => $request->input('name'),
        'id_number' => $request->input('id_number'),
        'subject' => $request->input('subject'),
        'grade' => $request->input('grade'),
    ]);

    return back()->with('success', 'Grade added successfully.');
}
}
