<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PyroMans\Auxillary\FileUpload;
use PyroMans\Auxillary\Translit;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Social;

class SocialsController extends ControllerBase
{
    public function index()
    {
        $socials = Social::get();

        return view('admin.socials.index', ['socials' => $socials]);
    }

    public function edit(Request $request)
    {
        if (!intval($request->input('id'))) {
            $this->validateInput($request);
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $fileInfo = FileUpload::uploadAndMakeThumb(
                    $icon,
                    'social',
                    Translit::make_lat($request->input('name')),
                    24,
                    24
                );
                if ($fileInfo) {
                    Social::create([
                        'name' => $request->input('name'),
                        'icon' => isset($fileInfo) ? $fileInfo['fileUrl'] : '',
                        'thumb' => isset($fileInfo) ? $fileInfo['thumbUrl'] : '',
                        'url' => $request->input('url'),
                    ]);

                    return redirect()->route('admin.socials')->with('success', 'Соціалку додано');
                }

                return redirect()->route('admin.socials')->with('error', 'Соціалку не додано');
            }

            return redirect()->route('admin.socials')->with('error', 'Ви не вибрали зображення. Ви довбойоб');
        } else {
            $id = intval($request->input('id'));
            $social = Social::find($id);
            $this->validateInputUpd($request);
            $social->name = $request->input('name');
            $social->url = $request->input('url');
            if ($request->hasFile('icon')) {
                FileUpload::deleteImageAndThumb($social->icon, $social->thumb);
                $icon = $request->file('icon');
                $fileInfo = FileUpload::uploadAndMakeThumb(
                    $icon,
                    'social',
                    Translit::make_lat($request->input('name')),
                    24,
                    24
                );
                if ($fileInfo) {
                    $social->icon = isset($fileInfo) ? $fileInfo['fileUrl'] : '';
                    $social->thumb = isset($fileInfo) ? $fileInfo['thumbUrl'] : '';
                }
            }
            if ($social->save()) {
                return redirect()->route('admin.socials')->with('success', 'Соціалку збережено');
            }

            return redirect()->route('admin.socials')->with('error', 'Соціалку не збережено. Хуйня получилася');
        }
    }

    public function getOne(int $id)
    {
        $social = Social::find($id);
        if (!empty($social)) {
            return $social;
        }

        return false;
    }

    public function delete($id)
    {
        $social = Social::find($id);
        if (empty($social)) {
            return redirect()->route('admin.socials')->with('error', 'Немає такої соціалки. Ідіть в жопу');
        } else {
            FileUpload::deleteImageAndThumb($social->icon, $social->thumb);
            if ($social->delete()) {
                return redirect()->route('admin.socials')->with('success', 'Соціалку видалено');
            }

            return redirect()->route('admin.socials')->with('error', 'Трапилась хуйня на сервері. Спробуйте пізніше.');
        }
    }

    private function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'icon' => 'required|mimes:jpeg,bmp,png',
            'url' => 'required|max:255',
        ]);
    }

    private function validateInputUpd(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
        ]);
    }
}
