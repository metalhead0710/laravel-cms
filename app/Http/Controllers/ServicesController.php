<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', ['services' =>$services]);
    }
}
