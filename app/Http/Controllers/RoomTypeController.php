<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\AccountType;
use App\Models\RoomType;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'name' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:5|max:255',
        ]);

        RoomType::create($validated);
        
        return redirect()->route('admin.room-types')->with('success', 'Room type successfully created');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        //
    }
}
