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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        $staffs = User::query()->withTrashed()
            ->where('account_type', AccountType::Staff)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', "%{$request->search}%")
                        ->orWhere('last_name', 'like', "%{$request->search}%");
                });
            })
            ->when($request->status === 'active', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($request->status === 'inactive', function ($query) {
                $query->onlyTrashed();
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        if ($staff->account_type !== AccountType::Staff) {
            return redirect()->route('admin.staff.index')->with('info', 'Staff update failed, please try again');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($staff->id)],
            'phone' => ['required', 'digits:11', 'regex:/^0[0-9]{10}$/'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'edit')
                ->withInput()
                ->with('edit_staff_id', $staff->id);
        }

        $staff->fill($validator->validated());

        if (! $staff->isDirty()) {
            return redirect()
                ->route('admin.staff.index')
                ->with('info', 'No changes were made.');
        }

        $staff->save();

        return redirect()->back()->with('success', 'Staff details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        if ($staff->account_type !== AccountType::Staff) {
            return redirect()->route('admin.staff.index')->with('info', 'Staff deactivation failed, please try again');
        }
        Log::info('Staff deactivated: ' . $staff->id . ' by ' . Auth::user()->fullName);
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff deactivated successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(User $staff)
    {
        if ($staff->account_type !== AccountType::Staff) {
            return redirect()->route('admin.staff.index')->with('info', 'Staff activation failed, please try again');
        }
        Log::info('Staff activated: ' . $staff->id . ' by ' . Auth::user()->fullName);
        $staff->restore();
        return redirect()->route('admin.staff.index')->with('success', 'Staff activated successfully.');
    }
}
