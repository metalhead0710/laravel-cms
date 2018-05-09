<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PyroMans\Auxillary\FileUpload;
use PyroMans\Http\Requests;
use PyroMans\Http\Controllers\ControllerBase;
use PyroMans\Photo;
use PyroMans\PhotoCategory;
use File;
use Image;
use PyroMans\Auxillary\Translit;
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

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $folder = 'photos/' . uniqid('photocat');
            $fileInfo = FileUpload::uploadAndMakeThumb(
                $photo,
                $folder,
                'photocat',
                350,
                250
            );
        }
        if (PhotoCategory::create([
            'name' => $request->input('name'),
            'slug' => Translit::make_lat($request->input('name')),
            'folder' => isset($fileInfo) ? $fileInfo['folder'] : '',
            'picture' => isset($fileInfo) ? $fileInfo['fileUrl'] : '',
            'thumb' => isset($fileInfo) ? $fileInfo['thumbUrl'] : '',
        ])) {
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

        if($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $folder = $photocat->folder;
            FileUpload::deleteImageAndThumb($photocat->picture, $photocat->thumb);
            $fileInfo = FileUpload::uploadAndMakeThumb(
                $photo,
                $folder,
                'photocat',
                350,
                250
            );
            if ($fileInfo) {
                $photocat->picture = $fileInfo['fileUrl'];
                $photocat->thumb = $fileInfo['thumbUrl'];
            }
        }
        if($photocat->name != $request->input('name'))
        {
            $photocat->name = $request->input('name');
            $photocat->slug = Translit::make_lat($request->input('name'));
        }

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
            $photoArray = [];
            foreach($request->file('photos') as $photo)
            {
                $fileInfo = FileUpload::uploadAndMakeThumb(
                    $photo,
                    $folder,
                    'photo',
                    200,
                    150,
                    true
                );
                if ($fileInfo) {
                    array_push($photoArray, [
                        'id' => null,
                        'photo' => $fileInfo['fileUrl'],
                        'thumb' => $fileInfo['thumbUrl'],
                        'sortOrder' => 0,
                        'categoryId' => $photocat->id
                    ]);
                }
            }
            Photo::insert($photoArray);

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
