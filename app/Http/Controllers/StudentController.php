<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use PhpOffice\PhpWord\IOFactory;

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


    // Manual student entry
    public function store(Request $request)
    {
        $student = Student::where('name', $request->input('name'))
            ->where('id_number', $request->input('id_number'))
            ->where('course', $request->input('course'))
            ->first();

        if ($student) {
            return back()->with('error', 'Student already exists.');
        }

        Student::create([
            'name' => $request->input('name'),
            'id_number' => $request->input('id_number'),
            'course' => $request->input('course'),
        ]);

        return back()->with('success', 'Student added successfully.');
    }


    // Word file student upload
    public function upload(Request $request)
    {
        // Check the uploaded file
        $request->validate([
            'student_file' => 'required|file|mimes:docx|max:10240',
        ]);

        // Get the Word file
        $file = $request->file('student_file');

        // Read the Word document
        $document = IOFactory::load($file->getPathname());

        $sections = $document->getSections();

        if (count($sections) == 0) {
            return back()->with('error', 'The Word file is empty.');
        }

        $section = $sections[0];

        $lines = [];

        // Read the text from the Word document
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
            $existingStudent = Student::where('id_number', $idNumber)->first();

            if ($existingStudent) {
                $skipped++;
                continue;
            }

            // Add the student
            Student::create([
                'name' => $name,
                'id_number' => $idNumber,
                'course' => $course,
            ]);

            $added++;
        }

        return back()->with(
            'success',
            $added . ' students added successfully. ' .
            $skipped . ' entries were skipped.'
        );
    }
}