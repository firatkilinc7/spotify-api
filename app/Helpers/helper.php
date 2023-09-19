<?php

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as img;

function imageClipping($request_file){
    $file = $request_file;
    $size = getimagesize($file);
    $oran = array_values($size)[0] / 768;
    $img = img::make($file)->resize(768, (int)(array_values($size)[1] / $oran));
    return $img;
}

function uploadImage($picture, $path, $url){

    $image = imageClipping($picture);
    $img_name = $url . "_" .Str::random(3). "_" . date("_d.m.y_h-i-s") .".webp";
    $image->save(public_path() . $path .   "/" .$img_name, 80);
    return $img_name;
}

function characterChanger($string) {

    $replace = array(
        'ç' => 'c',
        'ğ' => 'g',
        'ı' => 'i',
        'ö' => 'o',
        'ş' => 's',
        'ü' => 'u',
        'Ç' => 'C',
        'Ğ' => 'G',
        'İ' => 'I',
        'Ö' => 'O',
        'Ş' => 'S',
        'Ü' => 'U',
        ' ' => ''
    );

    return strtr($string, $replace);
}

?>
