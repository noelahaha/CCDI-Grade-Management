<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\Subjects;

class AdminController extends Controller
{
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

            // Get current number of failed attempts
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

        return redirect('/admin');
    }

  public function admin()
{
    $requests = Requests::latest()->get();
    $subjects = Subjects::all();

    return view('admin', compact('requests', 'subjects'));
}
}