<?php

namespace PyroMans\Http\Controllers\Admin;

use PyroMans\Banner;
use DB;
use Illuminate\Http\Request;
use PyroMans\Auxillary\FileUpload;
use PyroMans\Http\Controllers\ControllerBase;

class BannerController extends ControllerBase
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(10);

        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,bmp,png',
        ]);

        if ($request->hasFile('image')) {
            $banner = $request->file('image');

            $fileInfo = FileUpload::uploadAndMakeThumb(
                $banner,
                'banners',
                "banner",
                350,
                250
            );
            if ($fileInfo) {
                Banner::create([
                    'file' => $fileInfo['fileUrl'],
                    'thumb' => $fileInfo['thumbUrl'],
                ]);

                return redirect()->route('admin.banners')->with('success', "Банер збережено");
            }

            return redirect()->route('admin.banners')->with('error', "Не можу зберегти банер");
        }

        return redirect()->route('admin.banners')->with('error', "Не можу зберегти банер");
    }

    public function sortOut(Request $request)
    {
        $ids = $request->input('ids');
        foreach ($ids as $row) {
            DB::table('banners')
                ->where('id', $row['id'])
                ->update(['sort_order' => $row['sort']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banners')->with('error', 'Немає такого банера.');
        }
        FileUpload::deleteImageAndThumb($banner->file, $banner->thumb);
        if ($banner->delete()) {
            return redirect()->route('admin.banners')->with('success', 'Банер видалено к хуям собачим.');
        }

        return redirect()->route('admin.banners')->with('error', 'Не можу видалити банер.');
    }
}
