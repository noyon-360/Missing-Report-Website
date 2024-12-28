<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MissingPersonController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'login_view'])->name('admin.login.view');
        Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('user/{id}', [AdminController::class, 'userProfile'])->name('user.profile');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});


Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'guest'], function () {
        // Authenticated page route
        Route::get('/login', [UserAuthController::class, 'login_view'])->name('login-view');
        Route::post('/login', [UserAuthController::class, 'login'])->name('login');

        Route::get('/register', [UserAuthController::class, 'register_view'])->name('register-view');
        Route::post('/register', [UserAuthController::class, 'register'])->name('register');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('user.dashboard');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    });
});


Route::get('auth/google', [UserAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [UserAuthController::class, 'handleGoogleCallback']);


// Add missing person route
Route::get('/add-missing-person', function () {
    return view('missing_person.add_missing_person');
})->name('add-missing-person');

Route::middleware(['auth:web,admin'])->group(function () {

    Route::post('/submit-missing-person', [MissingPersonController::class, 'store'])->name('submit-missing-person');

    Route::get('/missing-person-success/{id}', [MissingPersonController::class, 'showSuccess'])->name('missing-person-success');

    Route::get('/edit-missing-person/{id}', [MissingPersonController::class, 'edit'])->name('edit-missing-person');
    Route::put('/update-missing-person/{id}', [MissingPersonController::class, 'update'])->name('update-missing-person');
});
// Route::middleware(['auth:web, admin'])->get('/add-missing-person', [MissingPersonController::class, 'missiongPersonView'])->name('add-missing-person');
// Route::get('/add-missing-person', [MissingPersonController::class, 'missiongPersonView'])->name('add-missing-person');

// Route::post('/submit-missing-person', [MissingPersonController::class, 'store'])->name('submit-missing-person');


// Admin routes
// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// });