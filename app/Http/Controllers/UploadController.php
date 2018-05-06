<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validator;

class UploadController extends Controller
{
    public function index(Request $request, Validator $validator)
    {
        $v = $validator->make($request->all(), [
            'upload' => 'required|image',
        ]);

        $funcNum = $request->input('CKEditorFuncNum');

        if ($v->fails()) {
            return response(
                "<script>
					window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$v->errors()->first()}');
				</script>"
            );
        }

        $image = $request->file('upload');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . '/' . 'upload/ckeditor/' , $fileName);
        $url = asset('upload/ckeditor/'.$fileName);

        return response(
            "<script>
				window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Зображення завантажено');
			</script>"
        );
    }
}
