<?php

namespace PyroMans\Http\Controllers\Admin;

use PyroMans\Http\Controllers\Controller;

class PopupController extends Controller
{
    public function index(int $res)
    {
        return view('admin.popup.index', ['res' => $res]);
    }
}
