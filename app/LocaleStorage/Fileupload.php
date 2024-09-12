<?php

namespace App\LocaleStorage;

use App\Models\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Fileupload
{
    /**
     * Define public method fileupload() to upload the file server and database
     * @param array|object $request  
     * @param int $model_id int
     * @param $model  
     * @param int $width  
     * @param int $height
     * @param $request
     * @return array|object|bool|string
     */
    public static function upload(array|object $request, int $model_id, $model, int $width, int $height): array|object|bool|string
    {
        $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
        $image = ImageManager::gd()->read($request->image);
        $final_image = $image->resize($width, $height);
        $isUpload = $final_image->save(storage_path('app/public/categories/' . $filename));
        $url = asset('storage/categories/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_type' => $model,
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
