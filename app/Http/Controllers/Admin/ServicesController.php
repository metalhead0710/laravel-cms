<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

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

            $image = $request->file('pic');
            if($request->hasFile('pic'))
            {
                $folder = 'upload/services/';
                $fileName = uniqid('service') . '.' . $image->getClientOriginalExtension();
                $request->file('pic')->move(public_path() . '/' . $folder , $fileName );
            }
            if (
            Service::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'pic' => isset($fileName) && isset($folder) ? $folder . $fileName : '',
                    'html_id' => uniqid('service_id')
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
        }
        else
        {
            $this->validateInput($request);
            $image = $request->file('pic');

            if($request->hasFile('pic'))
            {
                File::delete(public_path() . '/' . $service->pic);

                $folder = 'upload/services/';
                $fileName = uniqid('service') . '.' . $image->getClientOriginalExtension();
                $request->file('pic')->move(public_path() . '/' . $folder , $fileName );
                $service->pic = $folder . $fileName;
            }
            if(isEmptyOrNullString($service->html_id))
            {
                $service->html_id = uniqid('service_id');
            }
            $service->name = $request->input('name');
            $service->description = $request->input('description');
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
            'pic' => 'mimes:jpeg,bmp,png'
        ]);
    }
}
