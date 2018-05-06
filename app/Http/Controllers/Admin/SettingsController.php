<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Image;
use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Service;
use PyroMans\Setting;
use PyroMans\Auxillary\FileUpload;

class SettingsController extends ControllerBase
{
    public function index()
    {
        $settings = Setting::find(1);

        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'mainTitle' => 'required|max:255',
            'subTitle' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required',
            'siteLogo' => 'mimes:jpeg,bmp,png'
        ]);
        $settings = Setting::find(1);
        if($request->hasFile('siteLogo'))
        {
            $siteLogo = $request->file('siteLogo');

            $fileArray = FileUpload::uploadAndMakeThumb(
                $siteLogo,
                "settings",
                "logo",
                350,
                250
            );
        }
        if ($settings == null) {
            $storeSettings = Setting::create([
                'mainTitle' => $request->input('mainTitle'),
                'subTitle' => $request->input('subTitle'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'siteLogo' => isset($fileArray) ? $fileArray['fileUrl'] : ''

            ]);
        }
        else {
            $settings->mainTitle = $request->input('mainTitle');
            $settings->subTitle = $request->input('subTitle');
            $settings->meta_description = $request->input('meta_description');
            $settings->meta_keywords = $request->input('meta_keywords');
            $settings->siteLogo = isset($fileArray) ? $fileArray['fileUrl'] : '';
            $storeSettings = $settings->save();
        }


        if ($storeSettings) {
            return redirect()->route('admin.settings')->with('success', 'Налаштування збережено');
        }
        return redirect()->route('admin.settings')->with('error', 'Налаштування не збережено');
    }
}
