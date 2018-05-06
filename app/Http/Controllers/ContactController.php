<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Contact;
use PyroMans\Message;
use Mail;
use Mockery\Exception;

class ContactController extends ControllerBase
{
    public function index()
    {
        $contact = Contact::first();
        return view('contacts.index', ['contacts' => $contact]);
    }

    public function sendEmail(Request $request)
    {
    	try {
		    $this->validate($request, [
			    'sendname' => 'required',
			    'email' => 'required|email|max:255',
			    'content' => 'required'
		    ]);
		    $result =Message::create([
			    'sendname' => $request->input('sendname'),
			    'email' => $request->input('email'),
			    'content' => $request->input('content'),
			    'isNew' => true
		    ]);
		    $data = $request->all();
		    Mail::send('contacts.email', ['data' => $data], function($message) use ($data) {
			    $email = Contact::first()->email;
			    $message->from($data['email'], $data['sendname']);
			    $message->to($email)->subject('З сайту продюсерського центру');
		    });

		    if($result)
		    {
			    return redirect(route ('contacts'))->with('success', 'Ваше повідомлення надіслано');
		    }
		    else if (!$result)
		    {
			    return redirect(route ('contacts'))->with('error', 'Неможливо надіслати повідомлення.');
		    }
	    } catch (Error $e){
		    return redirect(route ('contacts'))->with('error', $e->getMessage());
	    }

    }
}
