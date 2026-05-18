<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    //

    public function index()
    {
        return Contact::all();
    }

    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'name' => ['string', 'max:100', 'nullable'],
            'message' => ['required', 'string', 'max:256']
        ]);

        Contact::create($data);
        return redirect('/contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
