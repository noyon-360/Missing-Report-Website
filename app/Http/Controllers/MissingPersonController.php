<?php

namespace App\Http\Controllers;

use App\Models\MissingPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissingPersonController extends Controller
{
    public function store(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a missing person report.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'permanent_address' => 'required|string|max:500',
            'last_seen_location_description' => 'required|string|max:500',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'front_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_pictures.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validatedData;

        // Handle the front image upload
        if ($request->hasFile('front_image')) {
            $frontImage = $request->file('front_image');
            $data['front_image'] = $frontImage->store('uploads/front_images', 'public');
        }

        // Handle additional pictures upload
        if ($request->hasFile('additional_pictures')) {
            $additionalPictures = $request->file('additional_pictures');
            $data['additional_pictures'] = json_encode(array_map(fn($file) => $file->store('uploads/additional_pictures', 'public'), $additionalPictures));
        }

        // Add the authenticated user's information
        if (Auth::guard('admin')->check()) {
            $data['user_email'] = Auth::guard('admin')->user()->email;
            $data['user_id'] = Auth::guard('admin')->id();
        } elseif (Auth::guard('web')->check()) {
            $data['user_email'] =  Auth::guard('web')->user()->email;
            $data['user_id'] = Auth::guard('web')->id();
        } else {
            $data['user_email'] = 'unknown';
            $data['user_id'] = null; // Default values for unauthenticated submissions
        }

        // echo '<pre>';
        // print_r($data);

        // Store the data in the database
        $missingPerson = MissingPerson::create($data);

        return redirect()->route('missing-person-success', $missingPerson->id)->with('success', 'Missing person report submitted successfully.');
    }

    public function showSuccess($id)
    {
        $missingPerson = MissingPerson::findOrFail($id);
        return view('missing_person.missing_person_success', compact('missingPerson'));
    }

    public function edit($id)
    {
        $missingPerson = MissingPerson::findOrFail($id);
        return view('missing_person.edit_missing_person', compact('missingPerson'));
    }

    public function update(Request $request, $id)
    {
        $missingPerson = MissingPerson::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'permanent_address' => 'required|string|max:500',
            'last_seen_location_description' => 'required|string|max:500',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_pictures.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validatedData;

        // Handle the front image upload
        if ($request->hasFile('front_image')) {
            $frontImage = $request->file('front_image');
            $data['front_image'] = $frontImage->store('uploads/front_images', 'public');
        }

        // Handle additional pictures upload
        if ($request->hasFile('additional_pictures')) {
            $additionalPictures = $request->file('additional_pictures');
            $data['additional_pictures'] = json_encode(array_map(fn($file) => $file->store('uploads/additional_pictures', 'public'), $additionalPictures));
        }

        // Update the data in the database
        $missingPerson->update($data);

        return redirect()->route('missing-person-success', $missingPerson->id)->with('success', 'Missing person report updated successfully.');
    }
}