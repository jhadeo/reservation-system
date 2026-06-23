<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


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

        $validated = $request->validate([
            'room_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_id')->whereNull('deleted_at'),
            ],
            'name' => 'required|min:5|max:50',
            'hourly_rate'  => 'required|numeric|min:1',
            'max_pax'      => 'required|integer|min:1',
            'room_type_id' => 'required|exists:room_types,id',
            'photo'        => 'nullable|image',
            'description'  => 'required|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images', 'public');
        }

        Room::create([
            ...$validated,
            'is_available' => false,
            'featured'     => false,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $types = RoomType::pluck('name', 'id');
        return view('admin.rooms.edit', compact('room', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {

        $validated = $request->validate([
            'room_id' => [
                'required',
                'min:5',
                'max:50',
                Rule::unique('rooms', 'room_id')->ignore($room->id),
            ],
            'name'         => 'required|min:5|max:50',
            'hourly_rate'  => 'required|numeric|min:1',
            'max_pax'      => 'required|integer|min:1',
            'room_type_id' => 'required|exists:room_types,id',
            'photo'        => 'nullable|image',
            'description'  => 'required|max:255',
        ]);

        if ($request->hasFile('photo')) {
            if ($room->photo) {
                Storage::delete('public/' . $room->photo);
            }
            $validated['photo'] = $request->file('photo')->store('images', 'public');
        } else {
            unset($validated['photo']);
        }

        $validated['hourly_rate'] = (float) $validated['hourly_rate'];
        $validated['max_pax'] = (int) $validated['max_pax'];
        $validated['room_type_id'] = (int) $validated['room_type_id'];
        $validated['is_available'] = $request->has('is_available');
        $validated['featured'] = $request->has('featured');

        $room->fill($validated);

        if (!$room->isDirty()) {
            return redirect()->route('admin.rooms.index')->with('info', 'No changes were made.');
        }

        $room->save();
        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        Log::info('Room deleted: ' . $room->id . ' by ' . Auth::user()->fullName);
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }

    public function search(Request $request)
    {
        if (! $request->expectsJson()) {
            return redirect()->route('admin.rooms.index');
        }

        $search = $request->input('search');

        $results = Room::with('roomType')
            ->where('name', 'LIKE', "%{$search}%")
            ->get();

        $groupedRooms = $results
            ->groupBy('room_type_id')
            ->map(function ($rooms) {
                return [
                    'type_name' => $rooms->first()->roomType?->name ?? 'Untyped',
                    'rooms' => $rooms->values(),
                ];
            })
            ->values();

        return response()->json($groupedRooms);
    }
}
