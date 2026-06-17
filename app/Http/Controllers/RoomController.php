<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;
use App\AccountType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.rooms.index', [
            'rooms' => Room::with('roomType')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = RoomType::pluck('name', 'id');
        return view('admin.rooms.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ((!Auth::check()) || (Auth::user()->account_type !== AccountType::Admin)) {
            //silently return them home
            return redirect()->route('/', 404);
        }

        $validated = $request->validate([
            'id' => 'required|min:5|max:50|unique:rooms',
            'name' => 'required|min:5|max:50',
            'hourly_rate' => 'required|numeric|min:1',
            'max_pax' => 'required|integer|min:1',
            'room_type_id' => 'required|exists:room_types,id',
            'photo' => 'nullable|image',
            'description' => 'required|max:255'
        ]);

        Room::create([
            ...$validated,
            'is_available' => false,
            'featured' => false
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
