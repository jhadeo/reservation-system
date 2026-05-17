<?php

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/rooms', function () {
    $rooms = Room::all();
    $room_types = RoomType::all();
    return view('rooms', ['rooms' => $rooms, 'room_types'=> $room_types]);
});

Route::get('/reserve-slot', function () {
    return view('reservations/reserve-room');
});
