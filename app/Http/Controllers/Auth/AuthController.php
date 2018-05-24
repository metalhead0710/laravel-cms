<?php

namespace PyroMans\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use Mail;
use PyroMans\User;
use PyroMans\Contact;
use PyroMans\PasswordReset;
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
        return view('auth.check-email');
    }

	public function postCheckEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('email', $request->input('email'))->get()->first();

        if(count($user) > 0) {
            $token = $this->generateToken();
            PasswordReset::create([
                'email' => $request->input('email'),
                'token' => $token
            ]);

            $data = [
                'name' => $user->getNameOrUsername(),
                'url' => route('auth.resetPassword', ['token' => $token]),
                'toEmail' => $userEmail = $request->input('email')
            ];
            Mail::send('auth.passwords.email', ['data' => $data], function($message) use ($data) {
                //TODO: Make something with this shit
                /*$email = Contact::first()->email;

                $message->from($email);*/
                $message->to($data['toEmail'])->subject('Скинути пароль для продовження дамінациї');
            });
            return redirect()
                ->route('auth.login')
                ->with('success', 'Перевіряй пошту, там лінк на відновлення паролю досі прийшов, башка ти дирява!');
        }

        return redirect()->route('auth.checkEmail')->with('error', 'Іди нахуй, такого мила нема');
    }

    public function resetPassword(string $token)
    {
        $now = Carbon::now()->subMinutes(10);
        $pr = PasswordReset::where([
                ['token', '=', $token],
                ['created_at', '>', $now]
            ])
            ->first();
        if (count($pr) > 0) {
            return view ('auth.password-reset', ['token' => $token]);
        } else {
            return redirect()
                ->route('auth.login')
                ->with('error', 'Недійсна лінка, або час лінки вийшов. Пробуй ще, шльоцик)');
        }
    }

    public function postResetPassword(Request $request, string $token)
    {
        $this->validate($request, [
            'newPassword' => 'required|min:6',
            'newPasswordRepeat' => 'required|same:newPassword'
        ]);

        $email = PasswordReset::where('token', $token)->first()->email;
        if (!empty($email)) {
            $user = User::where('email', $email)->first();
            $user->password = bcrypt($request->input('newPassword'));

            if ($user->save()) {
                return redirect()
                    ->route('auth.login')
                    ->with('success', 'Пароль змінено');
            }

            return redirect()
                ->route('auth.login')
                ->with('error', 'Хулі ти ломишся, іди вже нахуй!!!');
        }

        return redirect()
            ->route('auth.login')
            ->with('error', 'Хулі ти ломишся, іди вже нахуй!!!');
    }

    private function generateToken()
    {
        return md5(str_random(35));
    }
}
