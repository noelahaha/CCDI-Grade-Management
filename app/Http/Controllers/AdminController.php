<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Requests;
use App\Models\Subjects;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    // ========================================
    // ADMIN LOGIN
    // ========================================

    public function login(Request $request)
    {
        // Keep the name exactly as typed
        $name = $request->input('name');

        // Unique key for this admin + IP address
        $key = 'admin-login:' . $name . ':' . $request->ip();

        // Check if currently locked
        $lockedUntil = Cache::get($key . ':locked');

        if ($lockedUntil) {

            $seconds = now()->diffInSeconds(
                \Carbon\Carbon::parse($lockedUntil)
            );

            if ($seconds > 0) {
                return back()->with(
                    'error',
                    'Too many failed attempts. Try again in ' . $seconds . ' seconds.'
                );
            }

            Cache::forget($key . ':locked');
        }

        // Case-sensitive name comparison
        $admin = Admin::whereRaw('BINARY name = ?', [$name])->first();

        // Wrong username or password
        if (!$admin || !Hash::check($request->input('password'), $admin->password)) {

            $attempts = Cache::get($key . ':attempts', 0);

            $attempts++;

            // Store attempts for 15 minutes
            Cache::put(
                $key . ':attempts',
                $attempts,
                now()->addMinutes(15)
            );

            // 10 failed attempts = 15 minute lockout
            if ($attempts >= 10) {

                Cache::put(
                    $key . ':locked',
                    now()->addMinutes(15)->toDateTimeString(),
                    now()->addMinutes(15)
                );

                return back()->with(
                    'error',
                    'You are locked out for 15 minutes.'
                );
            }

            // 6 failed attempts = 2 minute cooldown
            if ($attempts >= 6) {

                Cache::put(
                    $key . ':locked',
                    now()->addMinutes(2)->toDateTimeString(),
                    now()->addMinutes(2)
                );

                return back()->with(
                    'error',
                    'Too many failed attempts. Wait 2 minutes.'
                );
            }

            // 3 failed attempts = 30 second cooldown
            if ($attempts >= 3) {

                Cache::put(
                    $key . ':locked',
                    now()->addSeconds(30)->toDateTimeString(),
                    now()->addSeconds(30)
                );

                return back()->with(
                    'error',
                    'Too many failed attempts. Wait 30 seconds.'
                );
            }

            return back()->with(
                'error',
                'Name or password is incorrect.'
            );
        }

       // Successful login
Cache::forget($key . ':attempts');
Cache::forget($key . ':locked');

// Regenerate session for security
$request->session()->regenerate();

// Save admin information in session
$request->session()->put('admin_id', $admin->id);
$request->session()->put('admin_name', $admin->name);

return redirect('/admin');
    }


    // ========================================
    // ADMIN DASHBOARD
    // ========================================

    public function admin(Request $request)
    {
        // ====================================
        // REQUEST MANAGEMENT
        // ====================================

        $query = Requests::query()->latest();

        // Apply request filters
        switch ($request->query('filter')) {

            case 'available':
                $query->where('available', 1);
                break;

            case 'not_available':
                $query->where('available', 0);
                break;

            case 'received':
                $query->where('received', 1);
                break;

            case 'today':
                $query->whereDate('created_at', today());
                break;

            case 'this_week':
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                break;

            case 'this_month':
                $query->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month);
                break;
        }

        $requests = $query->get();

        // Count requests not viewed yet
        $newRequestCount = Requests::where('seen', 0)->count();


        // ====================================
        // SUBJECT MANAGEMENT
        // ====================================

        // Keep all subjects available for other admin tabs
        $subjects = Subjects::all();


        // ====================================
        // MANUAL GRADE SEARCH
        // ====================================

        $selectedStudent = null;
        $selectedSchoolYear = '';

        $gradeSubjects = collect();
        $existingGrades = collect();

        // Get search inputs
        $lookup = trim(
            $request->query('student_lookup', '')
        );

        $schoolYear = trim(
            $request->query('school_year', '')
        );

        $gradeYear = $request->query('grade_year');

        $gradeSemester = $request->query('grade_semester');


        // Search only when required inputs are provided
        if (
            $lookup !== '' &&
            in_array($gradeYear, ['1st', '2nd', '3rd', '4th']) &&
            in_array($gradeSemester, ['1st', '2nd'])
        ) {

            // Search by ID number or student name
            $selectedStudent = Student::where(function ($query) use ($lookup) {

                $query->where('id_number', $lookup)
                    ->orWhere('name', 'LIKE', '%' . $lookup . '%');

            })
            ->orderByRaw(
                'CASE WHEN id_number = ? THEN 0 WHEN name = ? THEN 1 ELSE 2 END',
                [$lookup, $lookup]
            )
            ->first();


            if ($selectedStudent) {

                // Use entered school year.
                // If empty, use the student's school year.
                $selectedSchoolYear = $schoolYear !== ''
                    ? $schoolYear
                    : $selectedStudent->school_year;


                // Get subjects matching:
                // Student course
                // Selected year
                // Selected semester
                // Selected school year

                // Convert selected filters to match database values
$subjectYear = $gradeYear . ' Year';
$subjectSemester = $gradeSemester . ' Semester';

// Get matching subjects
$gradeSubjects = Subjects::where(
    'course',
    trim($selectedStudent->course)
)
    ->whereRaw('TRIM(year) = ?', [$subjectYear])
    ->whereRaw('TRIM(semester) = ?', [$subjectSemester])
    ->where('school_year', trim($selectedSchoolYear))
    ->orderBy('subject')
    ->get();


                // Get previously saved grades
                $existingGrades = Grade::where(
                    'id_number',
                    $selectedStudent->id_number
                )
                    ->whereIn(
                        'subject',
                        $gradeSubjects->pluck('id')
                    )
                    ->get()
                    ->keyBy('subject');

            }

            // Keep registrar on Grades tab after searching
            session()->flash('active_tab', 'grades');
        }


        // ====================================
        // RETURN ADMIN DASHBOARD
        // ====================================

        return view('admin', compact(
            'requests',
            'subjects',
            'newRequestCount',
            'selectedStudent',
            'selectedSchoolYear',
            'gradeSubjects',
            'existingGrades'
        ));
    }
}
