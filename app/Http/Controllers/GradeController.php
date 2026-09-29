<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use PhpOffice\PhpWord\IOFactory;

class GradeController extends Controller
{
    // Your existing manual grade entry
    public function store(Request $request)
    {
        $student = Grade::where('name', $request->input('name'))
            ->where('id_number', $request->input('id_number'))
            ->where('subject', $request->input('subject'))
            ->first();

        if ($student) {
            return back()->with('error', 'Grade already exists.');
        }

        Grade::create([
            'name' => $request->input('name'),
            'id_number' => $request->input('id_number'),
            'subject' => $request->input('subject'),
            'grade' => $request->input('grade'),
        ]);

        return back()->with('success', 'Grade added successfully.');
    }


    // Upload grades from Word file
    public function upload(Request $request)
    {
        // Check the uploaded file
        $request->validate([
            'grade_file' => 'required|file|mimes:docx|max:10240',
        ]);

        // Get the Word file
        $file = $request->file('grade_file');

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

        // Make sure the file has a subject and students
        if (count($lines) < 2) {
            return back()->with(
                'error',
                'The Word file must contain a subject and at least one student.'
            );
        }

        // First line is the subject
        $subject = $lines[0];

        $added = 0;
        $skipped = 0;

        // Read the student lines
        for ($i = 1; $i < count($lines); $i++) {

            $line = trim($lines[$i]);

            /*
             * Example:
             *
             * Juan Dela Cruz    95
             *
             * Everything before the last number = student name
             * Last number = grade
             */

            if (!preg_match('/^(.+?)\s+(\d+(?:\.\d+)?)$/', $line, $matches)) {
                $skipped++;
                continue;
            }

            $studentName = trim($matches[1]);
            $grade = trim($matches[2]);

            // Find the student in the students table
            $student = Student::where('name', $studentName)->first();

            if (!$student) {
                $skipped++;
                continue;
            }

            // Check if the grade already exists
            $existingGrade = Grade::where('name', $student->name)
                ->where('id_number', $student->id_number)
                ->where('subject', $subject)
                ->first();

            if ($existingGrade) {
                $skipped++;
                continue;
            }

            // Add the grade
            Grade::create([
                'name' => $student->name,
                'id_number' => $student->id_number,
                'subject' => $subject,
                'grade' => $grade,
            ]);

            $added++;
        }

        return back()->with(
            'success',
            $added . ' grades uploaded successfully. ' .
            $skipped . ' entries were skipped.'
        );
    }
}