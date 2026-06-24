<?php

namespace Modules\Categories\Contracts;

interface AddProductSpecificationServiceInterface
{
    public function syncSpecifications(int $productId, array $values):void;
}
