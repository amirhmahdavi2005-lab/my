<?php

namespace Modules\Products\Repositories;

use Modules\Products\Contracts\ProductDetailRepositoryInterface;
use Modules\Products\Models\ProductDetail;

class ProductDetailRepository implements ProductDetailRepositoryInterface
{

    public function destroy($product_id, array $options)
    {
        ProductDetail::where('product_id', $product_id)->whereIn('name', $options)
            ->whereIn('name', $options)->delete();
    }

    public function create(array $data)
    {
    }

    public function getDetail(int $productId): array
    {
        return ProductDetail::where('product_id', $productId)
            ->pluck('value', 'name')->toArray();
    }
}
