<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::where('account_type', AccountType::Staff)->paginate(15);

        return view('admin.staff.index', [
            'staffs' => $staffs
        ]);
    }

    //Search for a resource/s
    public function search(Request $request)
    {
        $search = $request->input('search');

        $staffs = User::where('account_type', AccountType::Staff)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json($staffs);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $staff)
    {
        if ($staff->account_type == AccountType::Admin || $staff->account_type == AccountType::Client) {
            return redirect()->route('admin.staff.index')->with('info', 'Staff viewing failed, please try again');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        //
    }
}
