<?php

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

Route::get('/login', function(){
    return view('auth.login');
});


Route::get('/register', [RegisteredGuestController::class, 'create']);
Route::post('/register',[RegisteredGuestController::class, 'store']);


