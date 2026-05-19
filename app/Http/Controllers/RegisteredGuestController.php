<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email','unique:users,email'],
            'phone' => ['required', 'digits:11', 'regex:/^0[0-9]{10}$/'],
            'password' => ['required','min:8']
        ]);

        // $data+= ["account_type" => AccountType::Guest->value]; // testing

        DB::transaction(function () use ($data) {
            User::create($data);
        });

        return redirect('/login')->with('success', 'Successfully created your account! You can now log in.');
    }
}
