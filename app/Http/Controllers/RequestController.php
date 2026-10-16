<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requests;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
        ]);

        Requests::create($request->all());

        return back()->with('success', 'Request submitted successfully.');
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

        return back();
    }

    public function printed(int $id)
    {
        $request = Requests::findOrFail($id);

        $request->printed = !$request->printed;
        $request->save();

        return back();
    }
}