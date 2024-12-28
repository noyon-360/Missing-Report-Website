<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Admin;
use App\Models\MissingPerson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }
    public function login_view()
    {
        return view('admin.admin_login');
    }

    public function dashboard(Request $request)
    {
        // $user_data = User::where('email')->get();

        $users = User::withCount('missingReports')->get();

        // echo '<pre>';
        // print_r($users);

        return view('admin.admin_dashboard', compact('users'));
    }

    public function userProfile($id)
    {
        $user = User::with('missingReports')->findOrFail($id); // Get user with their missing reports
        return view('profile.user_profile', compact('user'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.view')->with('success', 'You have been logged out.');
    }
}