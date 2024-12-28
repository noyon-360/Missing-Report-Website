<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MissingPerson;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view()
    {
        return view('welcome');
    }

    public function index()
    {
        // Fetch all records from the database
        $missingPersons = MissingPerson::all();

        // Pass the data to the view
        return view('welcome', compact('missingPersons'));
    }
}