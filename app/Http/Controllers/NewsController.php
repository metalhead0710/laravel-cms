<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'DESC')->paginate(9);

        return view('news.index', ['news' => $news]);
    }
}
