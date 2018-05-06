<?php

namespace Mik\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Http\Controllers\ControllerBase;
use Mik\Service;
use Mik\Setting;

class SettingsController extends ControllerBase
{
    public function index()
    {
        $settings = Setting::find(1);
        $services = Service::all();
        return view('admin.settings.index', ['settings' => $settings, 'services' => $services]);
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
        if($request->hasFile('photo'))
        {
            $siteLogo = $request-file('siteLogo');
            $folder = 'upload/settings/';
            $fileName = time() . '.' . $siteLogo->getClientOriginalExtension();
            $thumbName = time() . '.' . $siteLogo->getClientOriginalExtension();
            if (!file_exists( public_path() . '/' . $folder .'/thumbs/')) {
                mkdir(public_path() . '/' . $folder .'/thumbs/', 0777, true);
            }
            $thumbUrl = $folder .'/thumbs/' . $thumbName;
            $thumb = Image::make($siteLogo)->fit(350,250);
            $thumb->save(public_path() . '/' . $thumbUrl);
            $siteLogo->move(public_path() . '/' . $folder , $fileName );
        }
        if ($settings == null) {
            $storeSettings = Setting::create([
                'mainTitle' => $request->input('mainTitle'),
                'subTitle' => $request->input('subTitle'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'siteLogo' => isset($fileName) ? $fileName : '',
            ]);
        }
        else {
            $settings->mainTitle = $request->input('mainTitle');
            $settings->subTitle = $request->input('subTitle');
            $settings->meta_description = $request->input('meta_description');
            $settings->meta_keywords = $request->input('meta_keywords');
            $settings->siteLogo = isset($fileName) ? $fileName : '';
            $storeSettings = $settings->save();
        }


        if ($storeSettings) {
            return redirect()->route('admin.settings')->with('success', 'Налаштування збережено');
        }
        return redirect()->route('admin.settings')->with('error', 'Налаштування не збережено');
    }
}
