<?php

namespace PyroMans\Http\Controllers\Admin;

use PyroMans\User;
use Illuminate\Http\Request;
use PyroMans\Auxillary\FileUpload;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = User::first();

        return view('admin.user.edit', ['user' => $user]);
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|alpha_dash|max:20',
            'email' => 'required|email|max:255',
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
        ]);
        $user = User::first();
        $user->firstName = $request->input('firstName');
        $user->lastName = $request->input('lastName');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if (!empty($request->input('deletePhoto'))) {
            FileUpload::deleteImageAndThumb($user->photo, $user->thumb);
            $user->photo = null;
            $user->thumb = null;
        }
        if ($request->hasFile('photo')) {
            FileUpload::deleteImageAndThumb($user->photo, $user->thumb);
            $photo = $request->file('photo');
            $fileInfo = FileUpload::uploadAndMakeThumb(
                $photo,
                'user',
                'dominator',
                150,
                150
            );
            if ($fileInfo) {
                $user->photo = isset($fileInfo) ? $fileInfo['fileUrl'] : '';
                $user->thumb = isset($fileInfo) ? $fileInfo['thumbUrl'] : '';
            }
        }
        if ($user->save()) {
            return redirect()->route('admin.user')->with('success', 'Домінатор таки зберігся, тобі, курва, повезло');
        }

        return redirect()->route('admin.user')->with('error', 'Ой муділа... Хуй ти собачий, а не домінатор, закрий цю сторінку');
    }

    public function changePassword()
    {
        return view('admin.user.change-password');
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'newPasswordRepeat' => 'required|same:newPassword',
        ]);

        $user = User::first();

        if (Hash::check($request->input('oldPassword'), $user->password)) {
            $user->password = bcrypt($request->input('newPassword'));

            if ($user->save()) {
                return redirect()->route('admin.user.changePass')->with('success', "Ти поміняв пароль, ти дамінатор!!!");
            }
        }

        return redirect()->route('admin.user.changePass')->with('error',
            "Ой, бля, ломитись він сюди надумав, іди нахуй, шльоцик!!!");
    }
}
