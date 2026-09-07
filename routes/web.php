<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StudentKostController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OwnerBookingController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\ChatController;


/*
|--------------------------------------------------------------------------
| CHAT
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/chat/kost/{kost}',
        [ChatController::class, 'start']
    )->name('chat.start');

    Route::get(
        '/chat/{conversation}',
        [ChatController::class, 'show']
    )->name('chat.show');

    Route::get(
        '/chat/{conversation}/messages',
        [ChatController::class, 'messages']
    )->name('chat.messages');

    Route::post(
        '/chat/{conversation}/message',
        [ChatController::class, 'send']
    )->name('chat.send');
});



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




Route::middleware(['auth', 'role:student'])
    ->group(function () {

       
        Route::get('/student/dashboard', function () {
            return view('student.dashboard');
        })->name('student.dashboard');


       
        Route::get('/student/kosts', [StudentKostController::class, 'index'])
            ->name('student.kosts.index');

        Route::get('/student/kosts/{kost}', [StudentKostController::class, 'show'])
            ->name('student.kosts.show');


       
        Route::get('/student/bookings', [BookingController::class, 'index'])
            ->name('student.bookings.index');

        Route::get('/student/rooms/{room}/book', [BookingController::class, 'create'])
            ->name('student.bookings.create');

        Route::post('/student/rooms/{room}/book', [BookingController::class, 'store'])
            ->name('student.bookings.store');

        Route::get('/student/bookings/{booking}', [BookingController::class, 'show'])
            ->name('student.bookings.show');

        Route::get('/student/bantuan', [SupportChatController::class, 'index'])
            ->name('student.support.index');

        Route::post('/student/bantuan/send', [SupportChatController::class, 'send'])
            ->name('student.support.send');


        // ini midtrans token
        Route::get(
            '/student/bookings/{booking}/payment/token',
            [MidtransController::class, 'createSnapToken']
        )->name('student.bookings.payment.token');
    });



Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

       
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');


        
        Route::resource('kosts', KostController::class);


        
        Route::resource('kosts.rooms', RoomController::class)
            ->except(['show']);


        
        Route::get('/bookings', [OwnerBookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/{booking}', [OwnerBookingController::class, 'show'])
            ->name('bookings.show');
    });




// midtrans webhook
Route::post(
    '/midtrans/notification',
    [MidtransController::class, 'notification']
)->name('midtrans.notification');