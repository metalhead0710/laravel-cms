<?php

namespace PyroMans\Http\Controllers\Admin;

use PyroMans\Contact;
use Illuminate\Http\Request;
use PyroMans\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();

        return view('admin.contacts.index', ['contact' => $contact]);
    }

    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'phone' => 'max:20',
            'phone2' => 'max:20',
        ]);
        $contact = Contact::first();
        if (!$contact) {
            Contact::create([
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'phone2' => $request->input('phone2'),
            ]);
        } else {
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->phone2 = $request->input('phone2');
            $contact->save();
        }

        return redirect()->back()->with('success', 'Контакти збережено');
    }
}
