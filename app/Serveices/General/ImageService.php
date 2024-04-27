<?php

namespace App\Serveices\General;

class ImageService
{
    public function uploadImage($file)
    {
        $date = date('Y-m-d');
        $image_path = $file->store('/' . $date, 'public');
        return [
            'image' => $image_path,
        ];


    }
}
