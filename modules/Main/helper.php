<?php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use \Modules\Main\Models\VerificationCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

function addEvent($name,$object):void
{
    $events= config('app.events' , []);
    if (isset($events[$name])) {
        if (is_array($events[$name])) {
            if (!in_array($object,$events[$name] , true)) {
                $events[$name][] = $object;
            }
        }
        else{
            $events[$name] = [$object];
        }
        config()->set('app.events' , $events);
    }
}

function runEvent($name,$data,$return=false){
    $events = config('app.events', []);

    if (isset($events[$name])) {
        $validEvents = array_filter($events[$name], fn($event) => $event !== null);
        foreach ($validEvents as $event) {
            $object = new $event();
            if ($return) {
                $result = $object->handle($data);
                if ($result !== null) {
                    $data = $result;
                }
            } else {
                $object->handle($data);
            }
        }
    }
    if($return){
        return $data;
    }
}

function create_fit_pic($path,$fileName,$width=350,$height=350):void{
    if($fileName!=null){
        $manager = ImageManager::usingDriver(Driver::class);
        $thum = $manager->decodePath(fileDirectory($path));
        $thum->resize($width,$height);

        $destinationDir = fileDirectory('thumbnails');
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $thum->save(fileDirectory('thumbnails/'.$fileName));
    }
}

function replaceFaNumber(string|null $number): string|null
{
    if($number){
        $faDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $enDigits = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($faDigits, $enDigits, $number);
    }
    return  $number;
}
