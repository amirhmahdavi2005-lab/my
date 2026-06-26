<?php

namespace Modules\Products\Contracts;

interface ProductDetailRepositoryInterface
{
    public function destroy($product_id , array $options);

    public function create(array $data);

    public function getDetail(int $productId):array;
}
