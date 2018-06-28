<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PyroMans\Http\Controllers\Controller;

class PopupController extends Controller
{
    public function index(Request $request)
    {
        $res = $request->input('res');
        $message = $request->input('message');
        return view('admin.popup.index', ['res' => $res, 'message' => $message]);
    }
}
