<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subjects;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    // Manual grade entry
    

public function store(Request $request)
{
    // Validate submitted information
    $data = $request->validate([
        'student_id' => 'required|exists:students,id',

        'school_year' => [
            'required',
            'regex:/^\d{4}-\d{4}$/',
        ],

        'year' => 'required|in:1st,2nd,3rd,4th',

        'semester' => 'required|in:1st,2nd',

        'grades' => 'required|array|min:1',

        'grades.*.subject_id' => 'required|exists:subjects,id',

        'grades.*.grade' => 'nullable|numeric',

        'grades.*.status' => 'nullable|string|max:255',

        'grades.*.inc_reason' => 'nullable|string',
    ]);

    // Find student
    $student = Student::findOrFail($data['student_id']);

    // Convert dropdown values to the actual database format
    $subjectYear = $data['year'] . ' Year';
    $subjectSemester = $data['semester'] . ' Semester';

    // Verify submitted subjects
    foreach ($data['grades'] as $row) {

        $subject = Subjects::where('id', $row['subject_id'])
            ->where('course', $student->course)
            ->where('year', $subjectYear)
            ->where('semester', $subjectSemester)
            ->where('school_year', $data['school_year'])
            ->first();

        if (!$subject) {
            return back()
                ->with('error', 'Subject does not match the selected student and academic period.')
                ->with('active_tab', 'grades');
        }
    }

    $saved = 0;
    $skipped = 0;

    // Save or update grades
    \Illuminate\Support\Facades\DB::transaction(function () use (
        $data,
        $student,
        &$saved,
        &$skipped
    ) {

        foreach ($data['grades'] as $row) {

            $grade = trim((string) ($row['grade'] ?? ''));
            $status = trim((string) ($row['status'] ?? ''));
            $reason = trim((string) ($row['inc_reason'] ?? ''));

            // Skip completely empty rows
            if (
                $grade === '' &&
                $status === '' &&
                $reason === ''
            ) {
                $skipped++;
                continue;
            }

            // Find existing grade or create a new one
            Grade::updateOrCreate(
                [
                    'id_number' => $student->id_number,
                    'subject' => $row['subject_id'],
                ],
                [
                    'name' => $student->name,
                    'grade' => $grade === '' ? null : $grade,
                    'status' => $status === '' ? null : $status,
                    'inc_reason' => $reason === '' ? null : $reason,
                ]
            );

            $saved++;
        }
    });

    if ($saved == 0) {
        return back()
            ->with('error', 'Please enter at least one grade, status, or reason.')
            ->with('active_tab', 'grades');
    }

    // Return to the same student's grade table
    return redirect('/admin?' . http_build_query([
        'student_lookup' => $student->id_number,
        'school_year' => $data['school_year'],
        'grade_year' => $data['year'],
        'grade_semester' => $data['semester'],
    ]))
        ->with(
            'success',
            $saved . ' subject grades saved or updated successfully. ' .
            $skipped . ' empty rows were skipped.'
        )
        ->with('active_tab', 'grades');
}



    // Upload grades from Word file
    public function upload(Request $request)
    {
        $request->validate([
            'grade_file' => 'required|file|mimes:docx|max:10240',
        ]);

        $file = $request->file('grade_file');

        $document = IOFactory::load($file->getPathname());

        $sections = $document->getSections();

        if (count($sections) == 0) {
            return back()->with('error', 'The Word file is empty.');
        }

        $section = $sections[0];

        $lines = [];

        foreach ($section->getElements() as $element) {

            if ($element instanceof \PhpOffice\PhpWord\Element\Text) {

                $text = trim($element->getText());

                if ($text != '') {
                    $lines[] = $text;
                }
            }
        }

        if (count($lines) < 2) {
            return back()->with(
                'error',
                'The Word file must contain a subject and at least one student.'
            )->with('active_tab', 'grades');
        }

        // Find the subject using its name
        $subject = Subjects::where('subject', trim($lines[0]))->first();

        if (!$subject) {
            return back()->with(
                'error',
                'The subject "' . $lines[0] . '" does not exist.'
            )->with('active_tab', 'grades');
        }

        $added = 0;
        $skipped = 0;

        // Read student lines
        for ($i = 1; $i < count($lines); $i++) {

            $line = trim($lines[$i]);

            // Format: Student Name Grade Reason
            if (!preg_match(
                '/^(.+?)\s+(\d+(?:\.\d+)?)(?:\s+(.+))?$/',
                $line,
                $matches
            )) {
                $skipped++;
                continue;
            }

            $studentName = trim($matches[1]);
            $grade = trim($matches[2]);

            // Reason is optional
            $reason = isset($matches[3]) ? trim($matches[3]) : '';

            // Find the actual student record
            $student = Student::where('name', $studentName)->first();

            if (!$student) {
                $skipped++;
                continue;
            }

            // Check if the student already has a grade for this subject
            $existingGrade = Grade::where('id_number', $student->id_number)
                ->where('subject', $subject->id)
                ->first();

            if ($existingGrade) {
                $skipped++;
                continue;
            }

            // Save the grade
            Grade::create([
                'name' => $student->name,
                'id_number' => $student->id_number,
                'subject' => $subject->id,
                'grade' => $grade,
                'status' => null,
                'inc_reason' => $reason,
            ]);

            $added++;
        }

        return back()
            ->with(
                'success',
                $added . ' grades uploaded successfully. ' .
                $skipped . ' entries were skipped.'
            )
            ->with('active_tab', 'grades');
    }
}
