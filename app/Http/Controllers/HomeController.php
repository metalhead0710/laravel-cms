<?php

namespace Mik\Http\Controllers;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Service;
use Mik\Setting;

class HomeController extends ControllerBase
{
    public function index()
    {
        $settings = Setting::first();
        $services = Service::where('onMain', true)->get();
		return view('home.index', ['settings' => $settings, 'services' => $services]);
	}
}
