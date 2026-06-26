<?php

namespace Modules\Galleries\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddGallerySetting
{
    public function __invoke(Request $request): void
    {
        $data = $request->all();
        $config = config('gallery');
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    Log::info($file->getMimeType());
                    if (str_starts_with($file->getMimeType(), 'image/')) {
                        $imageUrl = upload_file_manual($file, 'images');
                        if ($imageUrl != null) {
                            $config[$key] = $imageUrl;
                        }
                    }
                } else {
                    $config[$key] = $value;
                }
            }
        }

        $content = '<?php

return ' . var_export($config, true) . ';';

        file_put_contents(
            config_path('gallery.php'),
            $content
        );
    }
}
