<?php

namespace PyroMans\Http\Controllers\Auth;

use Auth;
use PyroMans\Contact;
use PyroMans\User;
use Illuminate\Http\Request;
use PyroMans\Http\Controllers\Controller;


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

	public function checkEmail()
    {
        //TODO: Make email verification form
    }

	public function postCheckEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('email', $request->input('email'))->get();

        if(count($user) > 0) {
            $token = $this->generateToken();
            PasswordReset::create([
                'email' => $request->input('email'),
                'token' => $token
            ]);

            $data = [
                'name' => User::getNameOrUsername(),
                'url' => route('auth.resetPassword', ['token' => $token]),
                'toEmail' => $userEmail = $request->input('email')
            ];
            Mail::send('auth.passwords.email', ['data' => $data], function($message) use ($data) {
                $email = Contact::first()->email;

                $message->from($email);
                $message->to($data['toEmail'])->subject('Скинути пароль для продовження дамінациї');
            });
            return redirect()
                ->route('auth.checkEmail')
                ->with('success', 'Перевіряй пошту, там лінк на відновлення паролю досі прийшов, башка ти дирява!');
        }

        return redirect()->route('auth.check-email')->with('error', 'Іди нахуй, такого мила нема');
    }

    public function checkToken(string $token)
    {
        //Todo: handle this shiit
    }

    public function resetPassword()
    {
        //TODO: reset da fucking password
    }

    private function generateToken()
    {
        return bcrypt(str_random(35));
    }
}
