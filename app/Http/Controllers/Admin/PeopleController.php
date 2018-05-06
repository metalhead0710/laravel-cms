<?php

namespace Mik\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Http\Controllers\ControllerBase;
use Mik\Person;
use Image;
use File;

class PeopleController extends ControllerBase
{
    public function index()
    {
        $people = Person::all();

        return view('admin.people.index', ['people' => $people]);
    }

    public function add()
    {
        return view('admin.people.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate_input($request);
        $photo = $request->file('photo');

        if($request->hasFile('photo'))
        {
            $folder = 'upload/people/' . uniqid('person');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $thumbName = time() . '.' . $photo->getClientOriginalExtension();
            $thumbUrl = '/upload/people/thumbs/' . $thumbName;
            $thumb = Image::make($photo)->fit(600,400);
            $thumb->save(public_path() . '/upload/people/thumbs/' . $thumbName);
            $photo->move(public_path() . '/' . $folder , $fileName );
            $photoUrl = $folder . '/' . $fileName;
        }
        if (
        Person::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'photoUrl' => isset($photoUrl) ? $photoUrl : '',
            'folder' => isset($folder) ? $folder : '',
            'thumbUrl' => isset($thumbUrl) ? $thumbUrl : '',
            'info' => $request->input('info'),
            'position' => $request->input('position'),
            'vk' => $request->input('vk'),
            'facebook' => $request->input('facebook'),
            'skype' => $request->input('skype'),
            'twitter' => $request->input('twitter')
        ])
        )
        {
            return redirect()->route('admin.people')->with('success', 'Людину збережено');
        }
        return redirect()->back()->with('error', 'Не можу зберегти людину');
    }

    public function update($id)
    {
        $person = Person::find($id);
        if($person == null)
        {
            return redirect()->route('admin.people')->with('error', 'Немає такої людини.');
        }
        return view('admin.people.update', ['person' => $person]);
    }

    public function postUpdate(Request $request, $id)
    {
        $person = Person::find($id);
        if($person == null)
        {
            return redirect()->route('admin.people')->with('error', 'Немає такої людини.');
        }
        $this->validate_input($request);

        $photo = $request->file('photo');

        if($request->hasFile('photo'))
        {
            $folder = $person->folder;
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            File::delete(public_path() . '/' . $person->photoUrl, public_path(). $person->thumbUrl);
            $thumbName = time() . '.' . $photo->getClientOriginalExtension();
            $thumbUrl = '/upload/people/thumbs/' . $thumbName;
            $thumb = Image::make($photo)->fit(600,400);
            $thumb->save(public_path() . '/upload/people/thumbs/' . $thumbName);
            $request->file('photo')->move(public_path() . '/' . $folder , $fileName );
            $person->photoUrl = $folder . '/' . $fileName;
            $person->thumbUrl = $thumbUrl;
        }
        $person->first_name = $request->input('first_name');
        $person->last_name = $request->input('last_name');
        $person->position = $request->input('position');
        $person->info = $request->input('info');
        $person->vk = $request->input('vk');
        $person->facebook = $request->input('facebook');
        $person->skype = $request->input('skype');
        $person->twitter = $request->input('twitter');
        if ($person->save())
        {
            return redirect()->route('admin.people')->with('success', 'Людину збережено');
        }
        return redirect()->back()->with('error', 'Не можу зберегти людину');
    }

    public function delete($id)
    {
        $person = Person::find($id);
        if($person == null)
        {
            return redirect()->route('admin.people')->with('error', 'Немає такої людини.');
        }
        File::delete(   public_path() . '/' . $person->photoUrl,
                        public_path(). $person->thumbUrl
                    );
        if($person->folder != null)
        {
            File::deleteDirectory(public_path(). '/' . $person->folder);
        }
        if ($person->delete())
        {
            return redirect(route('admin.people'))->with('success', 'Людину видалено');
        }
        return redirect(route('admin.people'))->with('error', 'Не можу видалити людину');
    }

    private function validate_input($request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'photo' => 'mimes:jpeg,bmp,png',
            'position' => 'required|max:50',
            'vk' => 'url',
            'facebook' => 'url',
            'twitter' => 'url',
        ]);
    }
}
