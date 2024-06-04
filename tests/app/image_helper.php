<?php

namespace App\Helpers;

class ImageHelper
{
    public static function createMockImage($path, $width = 100, $height = 100, $color = [255, 0, 0])
    {
        $image = imagecreatetruecolor($width, $height);
        $background_color = imagecolorallocate($image, $color[0], $color[1], $color[2]);
        imagefill($image, 0, 0, $background_color);
        imagepng($image, $path);
        imagedestroy($image);
    }
}
