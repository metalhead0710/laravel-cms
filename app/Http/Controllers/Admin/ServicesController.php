<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PyroMans\Auxillary\FileUpload;
use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Service;
use File;

class ServicesController extends ControllerBase
{
    public function index()
    {
        $services = Service::orderBy('created_at')->paginate(10);
        return view('admin.services.index', ['services' => $services]);
    }

    public function edit( $id = null)
    {
        if( $id == null )
        {
            return view('admin.services.add');
        }
        $service = Service::find($id);
        return view('admin.services.update', ['service' => $service]);
    }
    public function postEdit(Request $request, $id = null)
    {
        $service = Service::find($id);

        if ($id == null)
        {
            $this->validateInput($request);


            if($request->hasFile('pic')) {
                $image = $request->file('pic');
                $fileInfo = FileUpload::uploadAndMakeThumb(
                    $image,
                    'services',
                    'service',
                    200,
                    100
                );
            }
            if (
            Service::create([
                    'name' => $request->input('name'),
                    'pic' => isset($fileName) && isset($fileInfo) ? $fileInfo['fileUrl'] : '',
                    'thumb' => isset($fileName) && isset($fileInfo) ? $fileInfo['thumbUrl'] : '',
                    'customCss' => $request->input('customCss'),
                    'customJs' => $request->input('customJs'),
                    'content' => $request->input('content'),
                ])
            )
            {
                return redirect()->route('admin.services')->with('success', 'Послугу збережено');
            }
            return redirect()->back()->with('error', 'Не можу зберегти послугу');
        }
        else if ( $service == null )
        {
            return redirect()->route('admin.services')->with('error', 'Немає такої послуги.');
        } else {
            $this->validateInput($request);

            if($request->hasFile('pic'))
            {
                $image = $request->file('pic');
                FileUpload::deleteImageAndThumb($service->pic, $service->thumb);
                $fileInfo = FileUpload::uploadAndMakeThumb(
                    $image,
                    'services',
                    'service',
                    200,
                    100
                );
                $service->pic = $fileInfo['fileUrl'];
                $service->thumb = $fileInfo['thumbUrl'];
            }
            $service->name = $request->input('name');
            $service->customCss = $request->input('customCss');
            $service->customJs = $request->input('customJs');
            $service->content = $request->input('content');
            if ($service->save())
            {
                return redirect()->route('admin.services')->with('success', 'Послугу збережено');
            }
            return redirect()->back()->with('error', 'Не можу зберегти послугу');
        }
    }

    public function delete($id)
    {
        $service = Service::find($id);
        if ( $service == null )
        {
            return redirect()->route('admin.services')->with('error', 'Немає такої послуги.');
        }

        File::delete( public_path() . '/' . $service->pic);

        if ($service->delete())
        {
            return redirect(route('admin.services'))->with('success', 'Послугу видалено');
        }
        return redirect(route('admin.services'))->with('error', 'Не можу видалити послугу');
    }

    protected  function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'pic' => 'mimes:jpeg,bmp,png',
            'content' => 'required'
        ]);
    }
}
