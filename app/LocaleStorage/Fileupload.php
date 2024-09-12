<?php

namespace App\LocaleStorage;

use App\Models\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Fileupload
{
    /**
     * Define public method fileupload() to upload the file server and database
     * @param $request
     */
    public static function upload($request, $model_id)
    {
        $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
        $image = ImageManager::gd()->read($request->image);
        $final_image = $image->resize(300, 300);
        $isUpload = $final_image->save(storage_path('app/public/categories/' . $filename));
        $url = asset('storage/categories/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_type' => Image::class,
                    'image_id'   => $model_id,
                    'disk'       => 'local',
                    'path'       => 'categories',
                    'url'        => $url,
                    'size'       => '1kb',
                ]
            );
            return $imageDatabase;
        } else {
            return false;
        }
    }
}
