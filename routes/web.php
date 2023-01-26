<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\CategoryComplaintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('complaint', [ComplaintController::class, 'index'])->name('complaint');
    Route::get('complaint/category', [CategoryComplaintController::class, 'index'])->name('complaintcategory');
    Route::post('complaint/category', [CategoryComplaintController::class, 'store'])->name('complaintcategory.store');
    Route::get('news', [NewsController::class, 'index'])->name('news');
    Route::get('news/category', [CategoryNewsController::class, 'index'])->name('newscategory');
    Route::post('news/category', [CategoryNewsController::class, 'store'])->name('newscategory.store');
    Route::get('user', [UserController::class, 'index'])->name('user');
});

require __DIR__ . '/auth.php';