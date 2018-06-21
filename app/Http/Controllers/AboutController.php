<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Person;
use PyroMans\Work;

class AboutController extends Controller
{
    public function index()
    {
        $people = Person::all();
        $works = Work::orderBy('created_at', 'DESC')->paginate(10);
        return view('about.index', ['people' => $people, 'works' => $works]);
    }
}
