<?php

namespace Mik\Http\Controllers;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\News;

class NewsController extends ControllerBase
{
    public function index()
    {
        $news = News::orderBy('created_at', 'DESC')->paginate(9);

        return view('news.index', ['news' => $news]);
    }
}
