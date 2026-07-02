<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')->withTrashed()->paginate(15);
        return view('admin/rooms/types/index', compact('roomTypes'));
    }

    /**
     * Search for resource/s.
     */
    public function search(Request $request)
    {
        if (!$request->expectsJson()) {
            return redirect()->route('admin.room-types.index');
        }

        $rooms = RoomType::query()
            ->withCount('rooms')->withTrashed()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->when($request->status === 'active', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($request->status === 'inactive', function ($query) {
                $query->onlyTrashed();
            })
            ->get();

        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('room_types', 'name')->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'create')
                ->withInput();
        }
        RoomType::create($validator->validated());

        return redirect()->route('admin.room-types.index')->with('success', 'Room type successfully created.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'edit')
                ->withInput()
                ->with('edit_room_type_id', $roomType->id);
        }

        $roomType->fill($validator->validated());

        if (! $roomType->isDirty()) {
            return redirect()
                ->route('admin.room-types')
                ->with('info', 'No changes were made.');
        }

        $roomType->save();

        return redirect()
            ->route('admin.room-types')
            ->with('success', 'Details changed successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return redirect()->route('admin.room-types.index')->with('info', 'Cannot delete a room type that still has rooms assigned.');
        }
        $roomType->delete();
        Log::info('Room type deleted: ' . $roomType->id . ' - ' . $roomType->name . ' by ' . Auth::user()->fullName);
        return redirect()->route('admin.room-types.index')->with('success', 'Successfully deleted room type.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(RoomType $roomType)
    {
        if (RoomType::where('name', $roomType->name)->whereNull('deleted_at')->exists()) {
            return redirect()
                ->route('admin.room-types.index')
                ->with('info', 'Cannot restore a room type whose name is already in use.');
        }

        $roomType->restore();
        Log::info('Room type restored: ' . $roomType->id . ' - ' . $roomType->name . ' by ' . Auth::user()->fullName);
        return redirect()->route('admin.room-types.index')->with('success', 'Successfully restored room type.');
    }
}
