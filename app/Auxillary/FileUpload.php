<?php
/**
 * functions for file uploading
 */

namespace PyroMans\Auxillary;

use File;
use Image;
use Illuminate\Http\UploadedFile;


class FileUpload
{
    const FOLDER = 'upload/';

    /**
     * Uploads File to a folder, returns array with info or false
     * @param UploadedFile $file
     * @param string  $folderName
     * @param string  $prefix
     *
     * @return array|bool
     */
    public static function uploadFile(UploadedFile $file, string $folderName, string $prefix)
    {
        $folder = self::FOLDER . $folderName;
        $fileName = uniqid($prefix) . '.' . $file->getClientOriginalExtension();
        if (!file_exists( public_path() . '/' . $folder )) {
            mkdir(public_path() . '/' . $folder, 0777, true);
        }

        $file->move(public_path() . '/' . $folder , $fileName );
        if (file_exists( public_path() . '/' . $folder . '/' . $fileName)) {
            $fileArray = [
                'fileName' => $fileName,
                'folder' => $folder,
                'fileUrl' => $folder . '/' . $fileName
            ];
            return $fileArray;
        }

        return false;
    }

    /**
     * Uploads File to a folder and makes thumb, returns array with info or false
     *
     * @param UploadedFile $file
     * @param string  $folderName
     * @param string  $prefix
     * @param int     $width
     * @param int     $height
     * @param bool    $strictFolder
     *
     * @return array|bool
     */
    public static function uploadAndMakeThumb(UploadedFile $file, string $folderName, string $prefix, int $width, int $height, $strictFolder = false)
    {
        if (!$strictFolder) {
            $folder = self::FOLDER . $folderName;
        } else {
            $folder = $folderName;
        }

        $fileName = uniqid($prefix) . '.' . $file->getClientOriginalExtension();
        if (!file_exists( public_path() . '/' . $folder )) {
            mkdir(public_path() . '/' . $folder, 0777, true);
        }
        if (!file_exists( public_path() . '/' . $folder .'/thumbs/')) {
            mkdir(public_path() . '/' . $folder .'/thumbs/', 0777, true);
        }
        $thumbUrl = $folder .'/thumbs/' . $fileName;
        $thumb = Image::make($file)->fit($width, $height);
        $thumb->save(public_path() . '/' . $thumbUrl);

        $file->move(public_path() . '/' . $folder , $fileName );
        if (file_exists( public_path() . '/' . $folder . '/' . $fileName)) {
            $fileArray = [
                'fileName' => $fileName,
                'folder' => $folder,
                'fileUrl' => $folder . '/' . $fileName,
                'thumbUrl' => $thumbUrl
            ];
            return $fileArray;
        }

        return false;
    }

    /**
     * @param string $file
     * @param string $thumb
     *
     * @return bool
     */
    public static function deleteImageAndThumb(string $file = null, string $thumb = null) : bool
    {
        if (!isset($file) || !isset($thumb)) {
            return false;
        }
        if (file_exists($file) && file_exists($thumb)) {
            File::delete( public_path() . "/$file",
                          public_path() . "/$thumb"
            );
            return true;
        }

        return false;
    }
}
