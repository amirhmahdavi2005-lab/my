<?php

namespace Modules\Products\Repositories;

use Modules\Main\Repositories\CrudRepository;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;

class ProductRepository extends CrudRepository implements ProductRepositoryInterface
{
    protected string $model=Product::class;

    public function create(array $data): product
    {
        $product = new Product($data);
        $product->saveOrFail();
        return $product;
    }

    public function updateProductImage($productId, $image):void
    {
        Product::where('id', $productId)->update(['image' => $image]);
    }

    public function findOrFail(int $productId)
    {
        return Product::findOrFail($productId);
    }

    public function update(Product $product): Product
    {
        $product->saveOrFail();
        return $product;
    }

    public function latest(string $column='id'): ?Product
    {
        return Product::latest($column)->first();
    }

    public function exists(array $condition):bool
    {
        return Product::where($condition)->exists();
    }
    public function findForShow(int $id, bool $withVariation = false):Product
    {
        $query = Product::query();

        if ($withVariation) {
            $query->with('variation');
        }

        return $query->findOrFail($id)
            ->makeVisible(['content', 'description']);
    }
}
