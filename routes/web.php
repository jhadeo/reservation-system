<?php

use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredGuestController;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactController::class, 'create']);
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/rooms', function () {
    $rooms = Room::all();
    $room_types = RoomType::all();
    return view('rooms', ['rooms' => $rooms, 'room_types' => $room_types]);
}); //refactor to use controllers

Route::get('/reserve-slot', function () {
    return view('reservations/reserve-room');
});


Route::get('/register', [RegisteredGuestController::class, 'create']);
Route::post('/register',[RegisteredGuestController::class, 'store']);

Route::get('/login', [SessionsController::class, 'create']);
Route::post('/login', [SessionsController::class, 'store']);
Route::delete('/logout', [SessionsController::class, 'destroy']);

Route::get('/client', function () {
    return view('client/welcome');
});


