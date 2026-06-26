<?php

namespace Modules\Products\Contracts;

interface ProductKeywordsRepositoryInterface
{
    public function create(array $data):void;

    public function destroy(int $productId):void;

    public function getTagsByProductId(int $productId):string;
}
