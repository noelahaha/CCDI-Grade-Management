<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Requests;
use Illuminate\Http\Request;

class RequestController extends Controller
{
 public function store(Request $request)
{
    $student = Student::find(session('student_id'));

    if (!$student) {
        return redirect('/login')
            ->with('error', 'Please log in first.');
    }

    Requests::create([
        'name' => $student->name,
        'id_number' => $student->id_number,
        'course' => $student->course,
    ]);

    return back()->with(
        'success',
        'Your request was submitted successfully.'
    );
}

    public function dashboard()
    {
        $requests = Requests::latest()->get();

        return view('admin', compact('requests'));
    }

    public function seen(int $id)
    {
        $request = Requests::findOrFail($id);

        $request->seen = !$request->seen;
        $request->save();

         return back()
        ->with('active_tab', 'requests');
    }

    public function printed(int $id)
    {
        $request = Requests::findOrFail($id);

        $request->printed = !$request->printed;
        $request->save();

         return back()
        ->with('active_tab', 'requests');
    }

    // Update Available / Not Available
// Update Available / Not Available
public function updateAvailability(Request $request, int $id)
{
    $request->validate([
        'available' => 'required|boolean',
    ]);

    $gradeRequest = Requests::findOrFail($id);

    $gradeRequest->available = $request->boolean('available');

    // If marked Available, automatically uncheck Received.
    if ($gradeRequest->available) {
        $gradeRequest->received = false;
    }

    $gradeRequest->save();

    return back()->with('active_tab', 'requests');
}


// Update Received
public function updateReceived(Request $request, int $id)
{
    $request->validate([
        'received' => 'required|boolean',
    ]);

    $gradeRequest = Requests::findOrFail($id);

    $gradeRequest->received = $request->boolean('received');

    // If marked Received, automatically uncheck Available.
    if ($gradeRequest->received) {
        $gradeRequest->available = false;
    }

    $gradeRequest->save();

    return back()->with('active_tab', 'requests');
}

public function markAllSeen()
{
    $updated = Requests::where('seen', 0)
        ->update(['seen' => 1]);

    return response()->json([
        'success' => true,
        'updated' => $updated,
    ]);
}
}