<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subjects;
use PhpOffice\PhpWord\IOFactory;

class GradeController extends Controller
{
    // Manual grade entry
   public function store(Request $request)
{
    $request->validate([
        'id_number' => 'required|exists:students,id_number',
        'subject' => 'required|exists:subjects,id',
        'grade' => 'required',
        'status' => 'nullable|string|max:50',
        'inc_reason' => 'nullable|string',
    ]);

    $student = Student::where('id_number', $request->id_number)
        ->first();

    $existingGrade = Grade::where('id_number', $student->id_number)
        ->where('subject', $request->subject)
        ->first();

    if ($existingGrade) {
        return back()
            ->with('error', 'Grade already exists.')
            ->with('active_tab', 'grades');
    }

    Grade::create([
        'name' => $student->name,
        'id_number' => $student->id_number,
        'subject' => $request->subject,
        'grade' => $request->grade,
        'status' => $request->status,
        'inc_reason' => $request->inc_reason,
    ]);

    return back()
        ->with('success', 'Grade added successfully.')
        ->with('active_tab', 'grades');
}

    // Upload grades from Word file
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'grade_file' => 'required|file|mimes:docx|max:10240',
    //     ]);

    //     $file = $request->file('grade_file');

    //     $document = IOFactory::load($file->getPathname());

    //     $sections = $document->getSections();

    //     if (count($sections) == 0) {
    //         return back()->with('error', 'The Word file is empty.');
    //     }

    //     $section = $sections[0];

    //     $lines = [];

    //     foreach ($section->getElements() as $element) {

    //         if ($element instanceof \PhpOffice\PhpWord\Element\Text) {

    //             $text = trim($element->getText());

    //             if ($text != '') {
    //                 $lines[] = $text;
    //             }
    //         }
    //     }

    //     if (count($lines) < 2) {
    //         return back()->with(
    //             'error',
    //             'The Word file must contain a subject and at least one student.'
    //         );
    //     }

    //     // Find the subject using its name
    //     $subject = Subjects::where('subject', trim($lines[0]))->first();

    //     if (!$subject) {
    //         return back()->with(
    //             'error',
    //             'The subject "' . $lines[0] . '" does not exist.'
    //         )->with('active_tab', 'grades');
    //     }

    //     $added = 0;
    //     $skipped = 0;

    //     // Read student lines
    //     for ($i = 1; $i < count($lines); $i++) {

    //         $line = trim($lines[$i]);

    //         if (!preg_match('/^(.+?)\s+(\d+(?:\.\d+)?)$/', $line, $matches)) {
    //             $skipped++;
    //             continue;
    //         }

    //         $studentName = trim($matches[1]);
    //         $grade = trim($matches[2]);

    //         $student = Student::where('name', $studentName)->first();

    //         if (!$student) {
    //             $skipped++;
    //             continue;
    //         }

    //         $existingGrade = Grade::where('id_number', $student->id_number)
    //             ->where('subject', $subject->id)
    //             ->first();

    //         if ($existingGrade) {
    //             $skipped++;
    //             continue;
    //         }

    //         Grade::create([
    //             'name' => $student->name,
    //             'id_number' => $student->id_number,
    //             'subject' => $subject->id,
    //             'grade' => $grade,
    //             'status' => $request->status,
    //             'inc_reason' => $request->inc_reason,
    //         ]);

    //         $added++;
    //     }

    //     return back()
    //         ->with(
    //             'success',
    //             $added . ' grades uploaded successfully. ' .
    //             $skipped . ' entries were skipped.'
    //         )
    //         ->with('active_tab', 'grades');
    //  }
}
