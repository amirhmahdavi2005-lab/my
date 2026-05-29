<?php
use \Illuminate\support\str;
use \Illuminate\Http\UploadedFile;
function replaceSpace($string):string
{
   $string = str_replace('-', ' ', $string);
   $string = str_replace('/', ' ', $string);
   return preg_replace('/\s+/', '-', $string);
}

function fileDirectory($path=' '):string{
    $seperator = '/';
    $firstChar = substr($path, 0, 1);
    if ($firstChar == '/') {
        $seperator = '';
    }
    return base_path('public'.$seperator.$path);
}

function upload_file_manual(UploadedFile $file, string $folder='uploads',$pix=''):string
{
    $filename = $pix .str::uuid() . '.' . $file->getClientOriginalExtension();
    $destinationPath = fileDirectory($folder);
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }
    $file->move($destinationPath, $filename);
    return $filename;
}



