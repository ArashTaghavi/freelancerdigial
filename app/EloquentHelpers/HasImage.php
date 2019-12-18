<?php

namespace App\EloquentHelpers;

use Image;

trait HasImage
{
    public function fillImage($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $input_image = $request->get('profile_image');

        if (!empty($input_image)) {
            $image = $this->upload_image($input_image, $this->image_path);
        } else {
            $image = null;
        }
        $this->fill(['profile_image' => $image]);
    }

    public function unlinkOriginalImage()
    {
        $file = public_path($this->getOriginal('profile_image'));
        if (is_file($file))
            unlink($file);
    }

    function upload_image($image, $destination_folder)
    {
        $image = \Intervention\Image\Facades\Image::make($image);
        $image_extension = $this->extensionFromMime($image->mime());
        $image_name = time();
        $disc_path = public_path("uploads/${destination_folder}");
        if (!file_exists($disc_path)) {
            mkdir($disc_path, 0755, true);
        }
        $image->save("{$disc_path}/{$image_name}.{$image_extension}");
        return "/uploads/${destination_folder}/{$image_name}.{$image_extension}";
    }


    function extensionFromMime($mime)
    {
        switch ($mime) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/jpg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            default:
                $extension = false;
                break;
        }
        return $extension;
    }
}
