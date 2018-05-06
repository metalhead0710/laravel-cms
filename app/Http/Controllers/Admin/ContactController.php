<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Contact;

class ContactController extends ControllerBase
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
            'vk' => 'url|max:250',
            'facebook' => 'url|max:250',
            'youtube' => 'url|max:250'
        ]);
        $contact = Contact::first();
        if (!$contact)
        {
            Contact::create([
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'phone2' => $request->input('phone2'),
                'vk' => $request->input('vk'),
                'facebook' => $request->input('facebook'),
                'youtube' => $request->input('youtube')
            ]);
        }
        else
        {
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->phone2 = $request->input('phone2');
            $contact->vk = $request->input('vk');
            $contact->facebook = $request->input('facebook');
            $contact->youtube = $request->input('youtube');
            $contact->save();
        }
        return redirect()->back()->with('success', 'Контакти збережено');
    }
}
