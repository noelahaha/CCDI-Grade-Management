<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use PhpOffice\PhpWord\IOFactory;

class StudentController extends Controller
{
    // ========================================
    // STUDENT LOGIN
    // ========================================

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
        ]);

        // Find an existing student
        $student = Student::where('name', $request->name)
            ->where('id_number', $request->id_number)
            ->first();

        // Reject incorrect information
        if (!$student) {
            return back()->with(
                'error',
                'Name or ID Number is incorrect.'
            );
        }

        // Store verified student ID in session
        session(['student_id' => $student->id]);

        return redirect('/dashboard');
    }


    // ========================================
    // MANUAL STUDENT ENTRY
    // ========================================

    public function addStudent(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year' => 'required',
            'semester' => 'required',
        ]);

        // Check if student already exists
        $student = Student::where('id_number', $data['id_number'])
            ->first();

        if ($student) {
            return back()
                ->with('error', 'Student already exists.')
                ->with('active_tab', 'students');
        }

        // Add the student
        Student::create($data);

        return back()
            ->with('success', 'Student added successfully.')
            ->with('active_tab', 'students');
    }


    // ========================================
    // WORD FILE STUDENT UPLOAD
    // ========================================

    public function upload(Request $request)
    {
        // Check uploaded file
        $request->validate([
            'student_file' => 'required|file|mimes:docx|max:10240',
        ]);

        // Get Word file
        $file = $request->file('student_file');

        // Read document
        $document = IOFactory::load($file->getPathname());

        $sections = $document->getSections();

        if (count($sections) == 0) {
            return back()->with('error', 'The Word file is empty.');
        }

        $section = $sections[0];

        $lines = [];

        // Read text from Word document
        foreach ($section->getElements() as $element) {

            if ($element instanceof \PhpOffice\PhpWord\Element\Text) {

                $text = trim($element->getText());

                if ($text != '') {
                    $lines[] = $text;
                }
            }
        }

        if (count($lines) == 0) {
            return back()->with('error', 'The Word file is empty.');
        }

        $added = 0;
        $skipped = 0;

        // Read each student
        foreach ($lines as $line) {

            /*
             * Example:
             *
             * Juan Dela Cruz    2020-00-001    BSCS
             */

            if (!preg_match(
                '/^(.+?)\s+(\d{4}-\d{2}-\d{3})\s+(.+)$/',
                $line,
                $matches
            )) {
                $skipped++;
                continue;
            }

            $name = trim($matches[1]);
            $idNumber = trim($matches[2]);
            $course = trim($matches[3]);

            // Check if ID number already exists
            $existingStudent = Student::where(
                'id_number',
                $idNumber
            )->first();

            if ($existingStudent) {
                $skipped++;
                continue;
            }

            // Add student
            Student::create([
                'name' => $name,
                'id_number' => $idNumber,
                'course' => $course,
            ]);

            $added++;
        }

        return back()
            ->with(
                'success',
                $added . ' students added successfully. ' .
                $skipped . ' entries were skipped.'
            )
            ->with('active_tab', 'students');
    }
}
