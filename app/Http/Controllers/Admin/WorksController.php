<?php

namespace Mik\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Http\Controllers\ControllerBase;
use Mik\Work;
use File;

class WorksController extends ControllerBase
{
    public function index()
    {
        $works = Work::orderBy('created_at', 'DESC')->paginate(5);;
        return view('admin.works.index', ['works' => $works]);
    }

    public function add()
    {
        return view('admin.works.add');
    }
    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'typeId' => 'required',
            'author' => 'max:60',
            'songname' => 'max:60',
        ]);
        if($request->input('typeId') == 100 && $request->hasFile('song'))
        {
            $folder = 'upload/music/';
            $fileName = uniqid('song') . '.' . $request->file('song')->getClientOriginalExtension();
            $request->file('song')->move(public_path($folder), $fileName);
            $songUrl = $folder . $fileName;
        }
        if (
            Work::create([
                'title' => $request->input('title'),
                'typeId' => $request->input('typeId'),
                'author' => $request->input('author'),
                'text' => $request->input('text'),
                'songname' => $request->input('songname'),
                'songUrl' => isset($songUrl) ? $songUrl : null,
                'video' => $request->input('video') == '' ? null : $request->input('video')

            ])
        )
        {
            return redirect()->route('admin.works')->with('success', 'Роботу збережено');
        }
        return redirect()->back()->with('error', 'Роботу не збережено');
    }
    public function update($id)
    {
        $work = Work::find($id);
        if($work == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої роботи.');
        }
        return view('admin.works.update', ['work' => $work]);
    }
    public function postUpdate(Request $request, $id)
    {
        $work = Work::find($id);

        if($work == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої роботи.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'typeId' => 'required',
            'author' => 'max:60',
            'songname' => 'max:60'
        ]);
        if($request->input('typeId') == 100 && $request->hasFile('song'))
        {
            File::delete(public_path() . '/' . $work->songUrl);
            $folder = 'upload/music/';
            $fileName = uniqid('song') . '.' . $request->file('song')->getClientOriginalExtension();
            $request->file('song')->move(public_path($folder), $fileName);
            $songUrl = $folder . '/' . $fileName;
        }
        $work->title = $request->input('title');
        $work->typeId = $request->input('typeId');
        $work->author = $request->input('author');
        $work->songname = $request->input('songname');
        $work->text = $request->input('text');
        $work->songUrl = isset($songUrl) ? $songUrl : null;
        $work->video = $request->input('video') != '' ? $request->input('video') : null;

        if ($work->save())
        {
            return redirect()->route('admin.works')->with('success', 'Роботу збережено');
        }
        return redirect()->back()->with('error', 'Роботу не збережено');
    }

    public function delete($id)
    {
        $work = Work::find($id);

        if($work == null)
        {
            return redirect()->route('admin.news')->with('error', 'Немає такої роботи.');
        }
        if($work->typeId == 100 && !empty($work->songUrl))
        {
            File::delete(public_path() . '/' . $work->songUrl);
        }

        if ($work->delete())
        {
            return redirect()->route('admin.works')->with('success', 'Роботу видалено.');
        }
        return redirect()->back()->with('error', 'Роботу не видалено.');
    }
}
