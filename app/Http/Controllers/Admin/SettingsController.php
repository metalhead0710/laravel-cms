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
        ]);
        $settings = Setting::find(1);
        if ($settings == null) {
            $storeSettings = Setting::create([
                'mainTitle' => $request->input('mainTitle'),
                'subTitle' => $request->input('subTitle'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description')
            ]);
        }
        else {
            $settings->mainTitle = $request->input('mainTitle');
            $settings->subTitle = $request->input('subTitle');
            $settings->meta_description = $request->input('meta_description');
            $settings->meta_keywords = $request->input('meta_keywords');
            $storeSettings = $settings->save();
        }
        $clear = Service::where('onMain', '=', true)
                ->update(['onMain' => false]);
        $chosen_ids = $request->input('onMain');
        $setAsMain = Service::whereIn('id', $chosen_ids)
                ->update(['onMain' => true]);

        if ($storeSettings && $clear && $setAsMain) {
            return redirect()->route('admin.settings')->with('success', 'Налаштування збережено');
        }
        return redirect()->route('admin.settings')->with('error', 'Налаштування не збережено');
    }
}
