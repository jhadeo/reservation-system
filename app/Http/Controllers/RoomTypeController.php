<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')->paginate(15);
        return view('admin/rooms/types/index', compact('roomTypes'));
    }

    /**
     * Search for resource/s.
     */
    public function search(Request $request)
    {
        $search =    $request->validate([
            'search' => 'required|string|min:1|max:100',
        ]);
        $results = RoomType::where('name', 'LIKE', "%{$search}%")->get();

        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('room_types', 'name')->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:5|max:255',
        ]);

        RoomType::create($validated);

        return redirect()->route('admin.room-types')->with('success', 'Room type successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:5|max:255',
        ]);

        $roomType->fill($validated);

        if (!$roomType->isDirty()) {
            return redirect()->route('admin.room-types')->with('info', 'No changes were made.');
        }

        $roomType->save();
        return redirect()->route('admin.room-types')->with('success', 'Details changed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return redirect()->route('admin.room-types')->with('info', 'Cannot delete a room type that still has rooms assigned.');
        }
        $roomType->delete();
        Log::info('Room type deleted: ' . $roomType->name . ' by ' . Auth::user()->fullName);
        return redirect()->route('admin.room-types')->with('success', 'Successfully deleted room type.');
    }
}
