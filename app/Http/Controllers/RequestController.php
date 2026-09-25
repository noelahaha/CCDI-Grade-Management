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
}
