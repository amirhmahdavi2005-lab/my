<?php

namespace Modules\Products\Services;

use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

class CreateProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected AddKeywordsService $addKeywords
    ){}

    public function handle(array $data, $user): Product
    {
        $fake = ($data['fake'] ?? 'false') === 'true' ? 'yes' : 'no';

        $productData = [
                'view' => 0,
                'user_id' => $user->id,
                'user_type' => get_class($user),
                'fake' => $fake,
                'slug' => replaceSpace($data['title']),
            ] + $data;

        if ($productData['user_type'] !== User::class) {
            $productData['status'] = -3;
        }

        $product = $this->productRepository->create($productData);

        ($this->addKeywords)->handle($product);

        runEvent('product.created', $product);

        return $product;
    }
}
