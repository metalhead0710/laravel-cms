<?php

namespace Mik\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Mik\User;
use Mik\Http\Requests;
use Mik\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    public function getRegister()
    {
        return view('auth.register');
    }
    public function postRegister(Request $request)
    {
        $this->validate($request, [
        	'username' => 'required|unique:users|alpha_dash|max:20',
        	'email' => 'required|unique:users|email|max:255',
        	'firstName' => 'required|max:255',
        	'lastName' => 'required|max:255',
        	'password' => 'required|min:6',
        	'password_repeat' => 'required|same:password'
        	
        ]);
        
        User::create([
        	'username' => $request->input('username'), 
	    	'email' => $request->input('email'), 
	    	'firstName' => $request->input('firstName'),
	    	'lastName' => $request->input('lastName'),
	    	'password' => bcrypt($request->input('password')),
	    	'isAdmin' => false
        ]);
        return redirect()->route('home')->with('success', 'Ви успішно зареєстровані');
    }  
    public function getLogin()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
        	'username' => 'required',
        	'password' => 'required'
        ]);
        if (!Auth::attempt($request->only(['username', 'password']), $request->has('remember')))
        {
			return redirect()->back()->with('error', 'Неправильний логін або пароль');
		}

        return redirect()->route('admin.home')->with('info', 'Вітаю, адмін');
		
    } 
    public function getLogout() 
    {
		Auth::logout();
		return redirect()->route('home');
	}
}
