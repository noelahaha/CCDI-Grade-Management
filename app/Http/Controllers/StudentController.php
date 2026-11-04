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

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
        ]);

        $student = Student::where('name', $request->name)
            ->where('id_number', $request->id_number)
            ->first();

        if (!$student) {
            return back()->with(
                'error',
                'Name or ID Number is incorrect.'
            );
        }

        // Save student database ID in session
        session(['student_id' => $student->id]);

        return redirect('/dashboard');
    }


    // ========================================
    // STUDENT INFORMATION SUBMISSION
    // ========================================

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:20',
        ]);

        $student = Student::where(
            'id_number',
            $data['id_number']
        )->first();

        if (!$student) {
            return back()->with(
                'error',
                'Student record not found.'
            );
        }

        if ($student->name !== $data['name']) {
            return back()->with(
                'error',
                'Student name does not match.'
            );
        }

        // Save student database ID in session
        session(['student_id' => $student->id]);

        return redirect('/dashboard');
    }


    // ========================================
    // MANUAL STUDENT ENTRY
    // ========================================

    
public function addStudent(Request $request)
{
    $data = $request->validate([
    'students' => 'required|array|min:1',

    'students.*.first_name' => 'required|string|max:70',
    'students.*.last_name' => 'required|string|max:70',
    'students.*.course' => 'required|string|max:50',
    'students.*.year' => 'required|in:1st,2nd,3rd,4th',
    'students.*.semester' => 'required|in:1st,2nd',
    'students.*.id_number' => [
        'required',
        'string',
        'regex:/^\d{4}-\d{2}-\d{3}$/',
    ],
    'students.*.school_year' => [
        'required',
        'string',
        'regex:/^\d{4}-\d{4}$/',
    ],
]);

    $added = 0;
    $skipped = 0;
    $seenIds = [];

    foreach ($data['students'] as $studentData) {

        $idNumber = $studentData['id_number'];

        // Check duplicate IDs in the submitted table
        if (isset($seenIds[$idNumber])) {
            $skipped++;
            continue;
        }

        $seenIds[$idNumber] = true;

        // Check if student already exists in database
        $existingStudent = Student::where(
            'id_number',
            $idNumber
        )->first();

        if ($existingStudent) {
            $skipped++;
            continue;
        }

        // Combine first and last name
        $name = $studentData['first_name'] . ' ' .
                $studentData['last_name'];

        // Save student
        Student::create([
            'name' => $name,
            'id_number' => $idNumber,
            'course' => $studentData['course'],
            'year' => $studentData['year'],
            'semester' => $studentData['semester'],
            'school_year' => $studentData['school_year'],
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



    // ========================================
    // WORD FILE STUDENT UPLOAD
    // ========================================

    public function upload(Request $request)
    {
        // Validate uploaded file
        $request->validate([
            'student_file' => 'required|file|mimes:docx|max:10240',
        ]);

        // Get uploaded Word file
        $file = $request->file('student_file');

        // Read Word document
        try {
            $document = IOFactory::load($file->getPathname());
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Unable to read the Word document. Please check the file.'
            )->with('active_tab', 'students');
        }

        $sections = $document->getSections();

        if (count($sections) == 0) {
            return back()
                ->with('error', 'The Word file is empty.')
                ->with('active_tab', 'students');
        }

        $lines = [];

        // Read all sections in the Word document
        foreach ($sections as $section) {

            foreach ($section->getElements() as $element) {

                // Check if the content is a Word table
                if ($element instanceof \PhpOffice\PhpWord\Element\Table) {

                    foreach ($element->getRows() as $row) {

                        $cells = [];

                        foreach ($row->getCells() as $cell) {

                            $cells[] = trim(
                                $this->extractWordText($cell)
                            );
                        }

                        // Combine table cells into one line
                        $line = implode(' | ', $cells);

                        if (trim(str_replace('|', '', $line)) != '') {
                            $lines[] = $line;
                        }
                    }

                } else {

                    // Read regular Word paragraphs
                    $text = trim(
                        $this->extractWordText($element)
                    );

                    if ($text != '') {
                        $lines[] = $text;
                    }
                }
            }
        }

        // Check if Word document contains readable text
        if (count($lines) == 0) {
            return back()
                ->with(
                    'error',
                    'No readable text found. Please check your Word document.'
                )
                ->with('active_tab', 'students');
        }

        $added = 0;
        $skipped = 0;

        // Process each student
        foreach ($lines as $line) {

            // Separate the 7 fields using |
            $parts = array_map('trim', explode('|', $line));

            // Skip header row
            if (strtolower($parts[0] ?? '') === 'first name') {
                continue;
            }

            // Check if there are exactly 7 fields
            if (count($parts) != 7) {
                $skipped++;
                continue;
            }

            // Get student information
            $firstName = $parts[0];
            $lastName = $parts[1];
            $course = $parts[2];
            $year = $parts[3];
            $semester = $parts[4];
            $idNumber = $parts[5];
            $schoolYear = $parts[6];

            // Check required fields
            if (
                $firstName == '' ||
                $lastName == '' ||
                $course == '' ||
                $year == '' ||
                $semester == '' ||
                $idNumber == '' ||
                $schoolYear == ''
            ) {
                $skipped++;
                continue;
            }

            // Validate ID number format
            if (!preg_match('/^\d{4}-\d{2}-\d{3}$/', $idNumber)) {
                $skipped++;
                continue;
            }

            // Validate school year format
            if (!preg_match('/^\d{4}-\d{4}$/', $schoolYear)) {
                $skipped++;
                continue;
            }

            // Combine first and last name
            $name = $firstName . ' ' . $lastName;

            // Check if ID number already exists
            $existingStudent = Student::where(
                'id_number',
                $idNumber
            )->first();

            if ($existingStudent) {
                $skipped++;
                continue;
            }

            // Save student to database
            Student::create([
                'name' => $name,
                'id_number' => $idNumber,
                'course' => $course,
                'year' => $year,
                'semester' => $semester,
                'school_year' => $schoolYear,
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


    // ========================================
    // EXTRACT TEXT FROM WORD ELEMENTS
    // ========================================

    private function extractWordText($element): string
    {
        // Read normal text
        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            return $element->getText();
        }

        // Handle line breaks
        if ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {
            return ' ';
        }

        // Read nested elements such as TextRun and TableCell
        if (method_exists($element, 'getElements')) {

            $text = '';

            foreach ($element->getElements() as $child) {
                $text .= $this->extractWordText($child);
            }

            return $text;
        }

        return '';
    }

}
