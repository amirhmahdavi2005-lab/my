<?php

namespace Modules\PriceVariation\Http\Controllers;

use Modules\PriceVariation\Contracts\CategoryPriceVariationItemsRepositoryInterface;

class VariationItemsController
{
    public function __construct(
        protected CategoryPriceVariationItemsRepositoryInterface $repository
    ){}

    public function __invoke():array
    {
        return $this->repository->getAllKeyedByCategory();
    }
}
