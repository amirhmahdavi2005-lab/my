<?php

namespace Modules\Products\Contracts;

use Modules\Main\Contracts\CrudRepositoryInterface;
use Modules\Products\Models\Product;

interface ProductRepositoryInterface extends CrudRepositoryInterface
{
    public function create(array $data):product;

    public function updateProductImage($productId, $image):void;

    public function findOrFail(int $productId);
    public function update(Product $product): Product;
    public function latest(string $column='id');
    public function exists(array $condition);

    public function findForShow(int $id, bool$withVariation = false):product;
}
