<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\News;
use Image;
use File;

class NewsController extends ControllerBase
{
    public function index()
    {
        $news = News::orderBy('created_at', 'DESC')->paginate(5);

        return view('admin.news.index', ['news' => $news]);
    }

    public function add()
    {
        return view('admin.news.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        $image = $request->file('image');

        if($request->hasFile('image'))
        {
            $folder = 'upload/news/' . uniqid('new');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $thumbName = time() . '.' . $image->getClientOriginalExtension();
            $thumbUrl = '/upload/news/thumbs/' . $thumbName;
            $thumb = Image::make($image)->fit(100,80);
            $thumb->save(public_path() . '/upload/news/thumbs/' . $thumbName);
            $request->file('image')->move(public_path() . '/' . $folder , $fileName );
        }
        if (
            News::create([
                'title' => $request->input('title'),
                'text' => $request->input('text'),
                'image' => isset($fileName) ? $fileName : '',
                'folder' => isset($folder) ? $folder : '',
                'thumbUrl' => isset($thumbUrl) ? $thumbUrl : ''
            ])
          )
        {
            return redirect()->route('admin.news')->with('success', 'Новину збережено');
        }
        return redirect()->back()->with('error', 'Якась срань помішала зберегти новину');
    }

    public function update($id)
    {
        $new = News::find($id);
        if($new == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини.');
        }
        return view('admin.news.update', ['new' => $new]);
    }

    public function postUpdate(Request $request, $id)
    {
        $new = News::find($id);
        if($new == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        $image = $request->file('image');

        if($request->hasFile('image'))
        {
            $folder = $new->folder;
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            File::delete(public_path() . '/' . $new->url(), public_path(). $new->thumbUrl);
            $thumbName = time() . '.' . $image->getClientOriginalExtension();
            $thumbUrl = '/upload/news/thumbs/' . $thumbName;
            $thumb = Image::make($image)->fit(100,80);
            $thumb->save(public_path() . '/upload/news/thumbs/' . $thumbName);
            $request->file('image')->move(public_path() . '/' . $folder , $fileName );
            $new->image = $fileName;
            $new->thumbUrl = $thumbUrl;
        }
        $new->title = $request->input('title');
        $new->text = $request->input('text');
        if ($new->save())
        {
            return redirect()->route('admin.news')->with('success', 'Новину збережено');
        }
        return redirect()->back()->with('error', 'Щось пішло не так');
    }

    public function delete($id)
    {
        $new = News::find($id);
        if($new == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини. ');
        }
        File::delete( public_path() . '/' . $new->url(),
                      public_path(). $new->thumbUrl
                    );
        if($new->folder != null)
        {
            File::deleteDirectory(public_path(). '/' . $new->folder);
        }
        if ($new->delete())
        {
            return redirect(route('admin.news'))->with('success', 'Новину видалено');
        }
        return redirect(route('admin.news'))->with('error', 'Не можу видалити новину');
    }
}
