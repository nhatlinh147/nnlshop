<?php

use Illuminate\Support\Facades\Auth;

/**
 * MAKE AVATAR FUNCTION
 */
if (!function_exists('makeAvatar')) {

    function makeAvatar($fontPath, $dest, $char)
    {
        $path = $dest;
        $image = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);
        imagettftext($image, 100, 0, 25, 150, $textcolor, $fontPath, $char);
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }
}
if (!function_exists('isCheckCustomer')) {
    function isCheckCustomer()
    {
        return  $check = Auth::guard('customer')->check();
    }
}