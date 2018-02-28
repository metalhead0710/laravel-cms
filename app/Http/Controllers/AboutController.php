<?php

namespace Mik\Http\Controllers;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Person;
use Mik\Work;

class AboutController extends ControllerBase
{
    public function index()
    {
        $people = Person::all();
        $works = Work::orderBy('created_at', 'DESC')->paginate(10);
        return view('about.index', ['people' => $people, 'works' => $works]);
    }
}
