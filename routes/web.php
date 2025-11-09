<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;


// Admin Route
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login_post'); 
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::any('/check-unique-availability', [AuthController::class, 'checkUniqueAvailability'])->name('check-unique-availability');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/post-forgot', [AuthController::class, 'submitForgot'])->name('forgot_post');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/reset-password/{token?}', [AuthController::class, 'resetPass'])->name('reset_password');
Route::post('/set-password', [AuthController::class, 'setPassword'])->name('set_password');
Route::get('/email-verify/{token?}', [AuthController::class, 'emailVerify'])->name('email_verify');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); ; 
Route::get('/logout', [AdminController::class, 'logout'])->name('admin_logout');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::get('events-list', [\App\Http\Controllers\Admin\EventController::class, 'list'])->name('events.list');
});

