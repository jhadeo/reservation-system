<?php

use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredGuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\ReservationStatus;
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

    Route::middleware('role:client')->prefix('client')->group(function () {
        Route::get('/home', function () {
            $reservations = Reservation::where('user_id', auth()->id())->get();
            return view('client/home', ['reservations' => $reservations]);
        });
    });

    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/home', function () {
            return view('staff/home');
        });
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {

        Route::get('/home', function () {
            $reservations = Reservation::whereIn('status', [ReservationStatus::Pending, ReservationStatus::Reserved, ReservationStatus::Active])
                ->with('user', 'room')
                ->latest('check_in_datetime')
                ->get(); // wtf is this?
            return view('admin/home', ['reservations' => $reservations]);
        });


        Route::get('/rooms', [RoomController::class, 'index'])->name('admin.rooms.index');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('admin.rooms.create');
        Route::post('/rooms/create', [RoomController::class, 'store'])->name('admin.rooms.store');
        Route::get('/rooms/search', [RoomController::class, 'search'])->name('admin.rooms.search');
        
        Route::get('/room-types', [RoomTypeController::class, 'index'])->name('admin.room-types');
        Route::post('/room-types/create', [RoomTypeController::class, 'store'])->name('admin.room-types.create');
        Route::get('/room-types/search', [RoomTypeController::class, 'search'])->name('admin.room-types.search');
        Route::put('/room-types/{roomType}/edit', [RoomTypeController::class, 'update'])->name('admin.room-types.update');
        Route::delete('/room-types/{roomType}/delete', [RoomTypeController::class, 'destroy'])->name('admin.room-types.destroy');

        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('admin.rooms.show');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::put('/rooms/{room}/edit', [RoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('/rooms/{room}/delete', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

    });
});
