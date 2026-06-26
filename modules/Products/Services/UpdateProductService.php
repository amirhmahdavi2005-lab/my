<?php

namespace Modules\Products\Services;

use Modules\Products\Actions\AddKeywords;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

class
UpdateProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected AddKeywordsService $addKeywordsService
    ) {}

    public function handle(array $data, int $id,  $user): Product
    {
        $product = $this->productRepository->findOrFail($id);

        $data['fake'] = ($data['fake'] ?? 'false') === 'true' ? 'yes' : 'no';

        if ($user::class!=User::class) {
            unset($data['status']);
            $data['status'] = -3;
        }

        $data['slug'] = replaceSpace($data['title']);
        // $data['user_id'] = $user->id;
        // $data['user_type'] = get_class($user);

        $product->fill($data);

        $this->productRepository->update($product);

        ($this->addKeywordsService)->handle($product);

        runEvent('product.updated', $product);

        return $product;
    }
}

