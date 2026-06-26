<?php

namespace Modules\PriceVariation\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PriceVariation\Contracts\CategoryPriceVariationItemsRepositoryInterface;

class CategoryPriceVariationItemsController
{
    public function __construct(
        protected CategoryPriceVariationItemsRepositoryInterface $repository
    ) {}

    public function index($category_id): ?object
    {
        return $this->repository->findByCategoryId($category_id);
    }

    public function store($category_id, Request $request): void
    {
        $this->repository->updateOrCreateByCategoryId($category_id, [
            'item1' => $request->post('item1'),
            'item2' => $request->post('item2'),
            'item3' => $request->post('item3'),
        ]);
    }

    public function items($category_id): array
    {
        return function_exists('getCategoriesVariations')
            ? getCategoriesVariations($category_id)
            : [];
    }
}
