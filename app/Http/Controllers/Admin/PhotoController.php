<?php

namespace Mik\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Mik\Http\Requests;
use Mik\Http\Controllers\ControllerBase;
use Mik\Photo;
use Mik\PhotoCategory;
use File;
use Image;
use Mik\Auxillary\Translit;
use Validator;

class PhotoController extends ControllerBase
{
    public function index()
    {
        $photocats = PhotoCategory::with('photos')->orderBy('created_at', 'DESC')->get();
        return view('admin.photos.index', ['photocats' => $photocats]);
    }

    public function create()
    {
        return view('admin.photos.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate_input($request);
        $photo = $request->file('photo');

        if($request->hasFile('photo'))
        {
            $folder = 'upload/photos/' . uniqid('photocat');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $thumbName = time() . '.' . $photo->getClientOriginalExtension();
            if (!file_exists( public_path() . '/' . $folder .'/thumbs/')) {
                mkdir(public_path() . '/' . $folder .'/thumbs/', 0777, true);
            }
            $thumbUrl = $folder .'/thumbs/' . $thumbName;
            $thumb = Image::make($photo)->fit(350,250);
            $thumb->save(public_path() . '/' . $thumbUrl);
            $photo->move(public_path() . '/' . $folder , $fileName );
        }
        if (
            PhotoCategory::create([
                'name' => $request->input('name'),
                'slug' => Translit::make_lat($request->input('name')),
                'picture' => isset($fileName) ? $fileName : '',
                'folder' => isset($folder) ? $folder : ''
            ])
        )
        {
            return redirect()->route('admin.photos')->with('success', 'Каталог збережено');
        }
        return redirect()->back()->with('error', 'Не можу зберегти каталог');
    }

    public function update($slug)
    {
        $photocat = PhotoCategory::where('slug', $slug)->first();

        return view('admin.photos.update', ['photocat' => $photocat]);
    }

    public function postUpdate(Request $request, $slug)
    {
        $this->validate($request, [
            'name' => 'required',
            'photo' => 'mimes:jpeg,bmp,png'
        ]);
        $photocat = PhotoCategory::where('slug', $slug)->first();
        $photo = $request->file('photo');
        if($request->hasFile('photo'))
        {
            $folder = $photocat->folder;
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            File::delete(public_path() . '/' . $photocat->photoUrl(), public_path(). '/' . $photocat->thumbUrl());
            $thumbName = time() . '.' . $photo->getClientOriginalExtension();
            $thumb = Image::make($photo)->fit(350,250);
            $thumb->save(public_path() . '/'. $folder .'/thumbs/' . $thumbName);
            $photo->move(public_path() . '/' . $folder , $fileName );
        }
        if($photocat->name != $request->input('name'))
        {
            $photocat->name = $request->input('name');
            $photocat->slug = Translit::make_lat($request->input('name'));
        }
        $photocat->picture = isset($fileName) ? $fileName : $photocat->picture;
        $photocat->folder = isset($folder) ? $folder : $photocat->folder;
        if($photocat->save())
        {
            return redirect()->route('admin.photos')->with('success', 'Каталог збережено');
        }
        return redirect()->back()->with('error', 'Не можу зберегти каталог');
    }

    public function addPhotos(Request $request)
    {
        $photocat = PhotoCategory::find($request->input('id'));

        if($request->hasFile('photos'))
        {
            $validator = Validator::make($request->all(), [
                'photos.*' => 'mimes:jpeg,bmp,png'
            ]);

            if ($validator->fails())
            {
                return redirect()->route('admin.photos')->with('error', 'Файли повинні бути у форматах *.jpg, *.bmp, *.png');
            }
            $folder = $photocat->folder;
            foreach($request->file('photos') as $photo)
            {
                $fileName =  uniqid('photo') . '.' . $photo->getClientOriginalExtension();
                $thumb = Image::make($photo)->fit(200,150);
                $thumb->save(public_path() . '/'. $folder .'/thumbs/' . $fileName);
                $photo->move(public_path() . '/' . $folder , $fileName );

                Photo::create([
                    'filename' => $fileName,
                    'categoryId' => $request->input('id')
                ]);
            }
            return redirect()
                   ->route('admin.photos.edit', ['slug' => $photocat->slug])
                   ->with('success', 'Фото завантажено');
        }
        return redirect()->back()->with('info', 'Ви не вибрали фото. Спробуйте ще, інтерфейс для дебілів же))');
    }

    public function edit($slug)
    {
        $photocat = PhotoCategory::with('photos')->where('slug', $slug)->orderBy('created_at','DESC')->first();
        return view('admin.photos.edit', ['photocat' => $photocat]);
    }

    public function deleteOne($categoryId, $id)
    {
        $photo = Photo::find($id);
        $photocat = PhotoCategory::select('folder' , 'slug')->find($categoryId);
        if($photo == null)
        {
            return redirect()->route('admin.photo')->with('error', 'Немає такої фотки.');
        }
        File::delete(   public_path() . '/' . $photocat->folder . '/' . $photo->filename,
                        public_path() . '/' . $photocat->folder . '/thumbs/' . $photo->filename
                    );
        if($photo->delete())
        {
            return redirect()
                ->route('admin.photos.edit', ['slug' => $photocat->slug])
                ->with('success', 'Фото видалено');
        }
        return redirect()->back()-with('error', 'Не можу видалити фото');
    }

    public function deletemassive(Request $request, $id)
    {
        $photocat = PhotoCategory::select('folder' , 'slug')->find($id);
        $checked = $request->input('pic');
        $res = [];
        foreach($checked as $value)
        {
            $photo = Photo::find($value);
            File::delete(   public_path() . '/' . $photocat->folder . '/' . $photo->filename,
                            public_path() . '/' . $photocat->folder . '/thumbs/' . $photo->filename
                        );
            if ($photo->delete())
            {
                array_push($res, true);
            }
        }
        $r = 0;
        for($i=0; $i<count($res); $i++)
        {
            if ($res[$i] == true)
            {
                $r++;
            }
        }
        if ($r == count($checked))
        {
            return redirect()
                ->route('admin.photos.edit', ['slug' => $photocat->slug])
                ->with('success', 'Фото видалено');
        }

        return redirect()->back()-with('error', 'Не можу видалити фото');
    }

    public function delete($id)
    {
        $photocat = PhotoCategory::find($id);
        if($photocat == null)
        {
            return redirect()->route('admin.photos')->with('error', 'Немає такого каталогу.');
        }
        File::deleteDirectory(public_path($photocat->folder));
        if (
            $photocat->delete()
        )
        {
            return redirect()
                    ->route('admin.photos')
                    ->with('success', 'Каталог видалено');
        }
        return redirect()->back()-with('error', 'Не можу видалити каталог');
    }




    private function validate_input(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:photocats',
            'photo' => 'mimes:jpeg,bmp,png'
        ]);
    }
}
