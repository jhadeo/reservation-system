<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\RegistrationSource;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::withTrashed()
            ->where('account_type', AccountType::Staff)
            ->paginate(15);

        return view('admin.staff.index', [
            'staffs' => $staffs
        ]);
    }

    //Search for a resource/s
    public function search(Request $request)
    {
        $search = $request->input('search');

        $staffs = User::withTrashed()
            ->where('account_type', AccountType::Staff)
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

        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'digits:11', 'regex:/^0[0-9]{10}$/'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'create')
                ->withInput();
        }

        $user = DB::transaction(function () use ($validator) {
            // ponytail: not setting password or sending invitation here — keep creation minimal
            $user = User::create([
                ...$validator->validate(),
                'registration_source' => RegistrationSource::Admin,
                'account_type' => AccountType::Staff,
                'created_by' => Auth::id(),
                'password' => Hash::make(Str::random(40)),
            ]);

            return $user;
        });

        $user->notify(new SetPasswordNotification());

        return redirect()->back()->with('success', 'User created successfully.');
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
