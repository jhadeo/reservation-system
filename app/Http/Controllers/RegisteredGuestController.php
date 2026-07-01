<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\RegistrationSource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredGuestController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */

    // TODO: email them after making an account
    public function store(Request $request)
    {
        // staff creates clients, clients cannot create other accounts
        if (Auth::check()) {
            $creator = Auth::user();

            if ($creator->account_type == AccountType::Staff) {
                $reg_src = RegistrationSource::Staff;
                $acc_type = AccountType::Client;
            } else {
                return abort(403, 'Forbidden');
            }

            $request->validate([
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'phone' => ['required', 'digits:11', 'regex:/^0[0-9]{10}$/'],
            ]);

            DB::transaction(function () use ($request, $reg_src, $acc_type) {
                // ponytail: not setting password or sending invitation here — keep creation minimal
                User::create([
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'registration_source' => $reg_src,
                    'account_type' => $acc_type,
                    'created_by' => Auth::id(),
                ]);
            });

            return redirect()->back()->with('success', 'User created successfully.');
        }

        // guest self-registration
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'digits:11', 'regex:/^0[0-9]{10}$/'],
            'password' => ['required', 'min:8']
        ]);

        DB::transaction(function () use ($request) {
            User::create([
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'registration_source' => RegistrationSource::Self,
                'account_type' => AccountType::Client,
                'password' => Hash::make($request->password)
            ]);
        });

        return redirect('/login')->with('success', 'Successfully created your account! You can now log in.');
    }
}
