<?php

namespace PyroMans\Http\Controllers\Admin;

use File;
use Image;
use PyroMans\News;
use Illuminate\Http\Request;
use PyroMans\Auxillary\FileUpload;
use PyroMans\Http\Controllers\ControllerBase;

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
            'image' => 'mimes:jpeg,bmp,png',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $fileInfo = FileUpload::uploadAndMakeThumb(
                $image,
                'news',
                "news",
                100,
                80
            );
        }
        if (
        News::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'image' => isset($fileInfo) ? $fileInfo['fileUrl'] : '',
            'thumbUrl' => isset($fileInfo) ? $fileInfo['thumbUrl'] : '',
        ])
        ) {
            return redirect()->route('admin.news')->with('success', 'Новину збережено');
        }

        return redirect()->back()->with('error', 'Якась срань помішала зберегти новину');
    }

    public function update($id)
    {
        $new = News::find($id);
        if ($new == null) {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини.');
        }

        return view('admin.news.update', ['new' => $new]);
    }

    public function postUpdate(Request $request, $id)
    {
        $new = News::find($id);
        if ($new == null) {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,bmp,png',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $fileInfo = FileUpload::uploadAndMakeThumb(
                $image,
                'news',
                "news",
                100,
                80
            );

            if ($fileInfo && FileUpload::deleteImageAndThumb($new->image, $new->thumbUrl)) {
                $new->image = $fileInfo['fileUrl'];
                $new->thumbUrl = $fileInfo['thumbUrl'];
            }
        }
        $new->title = $request->input('title');
        $new->text = $request->input('text');
        if ($new->save()) {
            return redirect()->route('admin.news')->with('success', 'Новину збережено');
        }
        return redirect()->back()->with('error', 'Щось пішло не так');
    }

    public function delete($id)
    {
        $new = News::find($id);
        if ($new == null) {
            return redirect()->route('admin.news')->with('error', 'Немає такої новини. ');
        }
        FileUpload::deleteImageAndThumb($new->image, $new->thumbUrl);
        if ($new->delete()) {
            return redirect(route('admin.news'))->with('success', 'Новину видалено');
        }
        return redirect(route('admin.news'))->with('error', 'Не можу видалити новину');
    }
}
