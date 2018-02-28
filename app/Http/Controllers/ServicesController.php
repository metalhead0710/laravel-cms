<?php

namespace Mik\Http\Controllers;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Service;

class ServicesController extends ControllerBase
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', ['services' =>$services]);
    }
}
