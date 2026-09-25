<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $admin = Admin::where('name', $request->input('name'))->first();

        if ($admin && Hash::check($request->input('password'), $admin->password)) {
            return redirect('/admin');
        }

        return back()->with('error', 'Name or password is incorrect.');
    }
}