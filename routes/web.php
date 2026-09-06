<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StudentKostController;
use App\Http\Controllers\MidtransController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register.form');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



//student
Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

});

Route::middleware(['auth','role:student'])->group(function () {

    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');


    // BOOKING STUDENT

    Route::get(
        '/student/bookings',
        [BookingController::class, 'index']
    )->name('student.bookings.index');

    Route::get(
        '/student/rooms/{room}/book',
        [BookingController::class, 'create']
    )->name('student.bookings.create');

    Route::post(
        '/student/rooms/{room}/book',
        [BookingController::class, 'store']
    )->name('student.bookings.store');

    Route::get(
        '/student/bookings/{booking}',
        [BookingController::class, 'show']
    )->name('student.bookings.show');
});



//owner
Route::middleware(['auth', 'role:owner'])->group(function () {

    Route::get('/owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {

    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    })->name('dashboard');

    Route::resource('kosts', KostController::class);
});

// OWNER
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('owner.dashboard');
        })->name('dashboard');

        Route::resource('kosts', KostController::class);

        Route::resource('kosts.rooms', RoomController::class)
            ->except(['show']);
    });

    Route::resource('kosts', KostController::class);

    Route::middleware([
    'auth',
    'role:student'
])->group(function () {

    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');


    // KOST STUDENT
    Route::get(
        '/student/kosts',
        [StudentKostController::class, 'index']
    )->name('student.kosts.index');

    Route::get(
        '/student/kosts/{kost}',
        [StudentKostController::class, 'show']
    )->name('student.kosts.show');


    // BOOKING
    Route::get(
        '/student/bookings',
        [BookingController::class, 'index']
    )->name('student.bookings.index');

    Route::get(
        '/student/rooms/{room}/book',
        [BookingController::class, 'create']
    )->name('student.bookings.create');

    Route::post(
        '/student/rooms/{room}/book',
        [BookingController::class, 'store']
    )->name('student.bookings.store');

    Route::get(
        '/student/bookings/{booking}',
        [BookingController::class, 'show']
    )->name('student.bookings.show');
});

Route::middleware('auth')->group(function () {
    Route::get(
        '/student/bookings/{booking}/payment/token',
        [MidtransController::class, 'createSnapToken']
    )->name('student.bookings.payment.token');
});