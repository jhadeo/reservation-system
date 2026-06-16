<?php

use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredGuestController;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




//routes that don't need any authentication/middleware
Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', [ContactController::class, 'create']);
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/rooms', function () {
    $rooms = Room::all();
    $room_types = RoomType::all();
    return view('pages.rooms', ['rooms' => $rooms, 'room_types' => $room_types]);
}); //refactor to use controllers

Route::get('/reserve-slot', function () {
    return view('reservations/reserve-room');
});


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredGuestController::class, 'create']);
    Route::post('/register', [RegisteredGuestController::class, 'store']);

    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/login', [SessionsController::class, 'store']);
});


Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionsController::class, 'destroy']);

    Route::middleware('role:client')->group(function () {
        Route::get('/client/home', function () {
            return view('client/home');
        });
    });

    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/home', function () {
            return view('staff/home');
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/home', function () {
            return view('admin/home');
        });
    });
});
