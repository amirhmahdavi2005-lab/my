<?php

namespace Modules\Products\Events\gallery;

use Modules\Galleries\Contracts\GalleryServiceInterface;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;

class AddProductGallery
{

    public function handle(Product $product): void
    {
        $galleryService=app(GalleryServiceInterface::class);
        $request = request();
        $galleryItems = $request->get('gallery');
        if (!is_array($galleryItems)) {
            return;
        }

        $position = 0;
        $user = $request->user();
        $userType = $user::class;
        $userId = $user->id;

        foreach ($galleryItems as $key => $value) {

            $galleryService->__invoke([
                'tableable_type' => Product::class,
                'tableable_id' => $product->id,
                'position' => $position,
                'path' => $value['path'],
                'user_id' => $userId,
                'user_type' => $userType,
            ], true);

            if ($key === 0) {
                $this->addMainPicture($product, $value['path']);
            }

            $position++;
        }
    }

    protected function addMainPicture(Product $product, string $path): void
    {
        $productRepo = app(ProductRepositoryInterface::class);
        $picName = str_replace('gallery/', '', $path);
        $productRepo->updateProductImage($product -> id ,$picName);
        create_fit_pic($path, $picName);
    }
}
