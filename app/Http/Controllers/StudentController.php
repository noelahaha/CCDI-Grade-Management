<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function login(Request $request)
    {
        $student = Student::where('name', $request->input('name'))
            ->where('id_number', $request->input('id_number'))
            ->first();

        if ($student) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Name or ID Number is incorrect.');
    }
}