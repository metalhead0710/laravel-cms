<?php

namespace PyroMans\Http\Controllers\Admin;

use PyroMans\Http\Controllers\ControllerBase;

class PopupController extends ControllerBase
{
    public function index($res)
    {
        return view('admin.popup.index', ['res' => $res]);
    }
}
