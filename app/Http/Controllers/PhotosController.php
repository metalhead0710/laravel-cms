<?php

namespace Mik\Http\Controllers;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Photo;
use Mik\PhotoCategory;

class PhotosController extends ControllerBase
{
    public function index()
    {
        $photocats = PhotoCategory::all();
        return view('photos.index', ['photocats' => $photocats]);
    }

    public function view($slug)
    {
        $photocat = PhotoCategory::with(['photos' => function($query)
                                        {
                                            $query->orderBy('created_at', 'DESC')
                                                  ->take(12);
                                        }])
                                   ->where('slug', $slug)
                                   ->first();
        if($photocat == null)
        {
            abort(404);
        }

        $count = Photo::where('categoryId', $photocat->id)->count();
        return view('photos.view', array('photocat'=>$photocat, 'count' => $count));
    }

    public function loadmore($id, $num)
    {
        $photos = Photo::where('categoryId', $id)->orderBy('created_at', 'DESC')->skip($num)->take(12)->get();
        $folder = PhotoCategory::select('folder')->find($id);
        return view('photos.partial.list', ['photos' => $photos, 'folder' => $folder->folder]);
    }
}
