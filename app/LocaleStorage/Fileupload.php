<?php

namespace App\LocaleStorage;

use App\Enums\Bucket;
use App\Models\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Fileupload
{
    /**
     * Define public method upload() to upload the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @param int $width
     * @param int $height
     * @param $request
     * @return array|object|bool|string
     */
    public static function upload(array | object $request, Bucket $bucket, int $model_id, $model, int $width, int $height): array | object | bool | string
    {
        $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
        $image = ImageManager::gd()->read($request->image);
        $final_image = $image->resize($width, $height);
        $isUpload = $final_image->save(storage_path('app/public/' . $bucket->toString() . '/' . $filename));
        $url = asset('storage/' . $bucket->toString() . '/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_type' => $model,
                    'image_id' => $model_id,
                    'disk' => 'local',
                    'path' => $bucket->toString(),
                    'url' => $url,
                    'size' => '1kb',
                ]
            );
            return $imageDatabase;
        } else {
            return false;
        }
    }

    /**
     * Define public method uploadFile() to uploadFile the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @return array|object|bool|string
     */
    public static function uploadFile(array | object $request, Bucket $bucket, int $model_id, $model): array | object | bool | string
    {
        // storage_path('app/public/' . $bucket->toString() . '/' . $filename)
        $filename = uniqid() . '-' . $request->request_attachment->getClientOriginalName();
        $isUpload = $request->request_attachment->storeAs($bucket->toString(), $filename, 'public');
        $url = asset('storage/' . $bucket->toString() . '/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_type' => $model,
                    'image_id' => $model_id,
                    'disk' => 'local',
                    'path' => $bucket->toString(),
                    'url' => $url,
                    'size' => '1kb',
                ]
            );
            return $imageDatabase;
        } else {
            return false;
        }
    }

    /**
     * Define public method fileupload() to upload the file server and database
     * @param array|object $request
     * @param int $model_id int
     * @param $oldCategory
     * @param $model
     * @param int $width
     * @param int $height
     * @param $request
     * @return array|object|bool|string
     */
    public static function update(array | object $request, $oldCategory, int $model_id, $model, int $width, int $height)
    {
        if ($request->image) {
            $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
            $image = ImageManager::gd()->read($request->image);
            $final_image = $image->resize($width, $height);
            $isUpload = $final_image->save(storage_path('app/public/categories/' . $filename));
            $url = asset('storage/categories/' . $filename);
            if ($isUpload) {
                $imageDatabase = Image::where('image_type', $model)->where('image_id', $oldCategory->id)->update(
                    [
                        'image_type' => $model,
                        'image_id' => $model_id,
                        'disk' => 'local',
                        'path' => 'categories',
                        'url' => $url,
                        'size' => '1kb',
                    ]
                );
                return $imageDatabase;
            } else {
                return false;
            }
        }
    }
}
