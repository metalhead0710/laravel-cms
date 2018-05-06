<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Service;
use PyroMans\Setting;

class HomeController extends ControllerBase
{
    public function index()
    {
        $settings = Setting::first();

		return view('home.index', ['settings' => $settings]);
	}
}
