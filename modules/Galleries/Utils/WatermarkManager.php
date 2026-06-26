<?php

namespace Modules\Galleries\Utils;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class WatermarkManager
{
    public function apply(string $imagePath): void
    {
        $manager = new ImageManager(new Driver());
        $img = $manager->read($imagePath);
        $img->place(
            config('gallery.image'),
            config('gallery.position'),
            intval(config('gallery.position_x')),
            intval(config('gallery.position_y'))
        );
        $img->save();
    }
}
