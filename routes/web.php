<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredGuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\StaffController;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\ReservationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




//routes that don't need any authentication/middleware
Route::get('/', function () {
    return view('pages.welcome');
})->name('landing');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', [ContactController::class, 'create']);
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/rooms', [RoomController::class, 'indexHome']);

Route::get('/reserve-slot', [ReservationController::class, 'create']);


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredGuestController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredGuestController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');

    Route::get('/reset-password', [ResetPasswordController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');

    Route::get('/forgot-password', [ResetPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'store'])->name('password.email');
});


Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionsController::class, 'destroy']);


    //Client
    Route::middleware('role:client')->prefix('client')->group(function () {
        Route::get('/home', function () {
            $reservations = Reservation::where('user_id', auth()->id())->get();
            return view('client/home', ['reservations' => $reservations]);
        });
    });

    //Staff
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/home', function () {
            return view('staff/home');
        });
    });


    //Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/home', function () {
            $reservations = Reservation::whereIn('status', [ReservationStatus::Pending, ReservationStatus::Reserved, ReservationStatus::Active])
                ->with('user', 'room')
                ->latest('check_in_datetime')
                ->get();
            return view('admin/home', ['reservations' => $reservations]);
        })->name('home');

        Route::prefix('rooms')->name('rooms.')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('index');
            Route::get('/create', [RoomController::class, 'create'])->name('create');
            Route::post('/create', [RoomController::class, 'store'])->name('store');
            Route::get('/search', [RoomController::class, 'search'])->name('search');
            Route::get('/{room}', [RoomController::class, 'show'])->name('show');
            Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
            Route::put('/{room}/edit', [RoomController::class, 'update'])->name('update');
            Route::delete('/{room}/delete', [RoomController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('room-types')->name('room-types.')->group(function () {
            Route::get('/', [RoomTypeController::class, 'index'])->name('index');
            Route::post('/create', [RoomTypeController::class, 'store'])->name('create');
            Route::get('/search', [RoomTypeController::class, 'search'])->name('search');
            Route::put('/{roomType}/edit', [RoomTypeController::class, 'update'])->name('update');
            Route::delete('/{roomType}/delete', [RoomTypeController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/', [StaffController::class, 'index'])->name('index');
            Route::post('/', [StaffController::class, 'store'])->name('store');
            Route::get('/search', [StaffController::class, 'search'])->name('search');
            Route::put('/{staff}/edit', [StaffController::class, 'update'])->name('update');
            Route::delete('/{staff}/delete',[StaffController::class,'destroy'])->name('destroy');
            Route::post('/{staff}/restore',[StaffController::class,'restore'])->withTrashed()->name('restore');
        });
    });
});
