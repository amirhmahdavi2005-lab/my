<?php

use Modules\PriceVariation\Services\GetCategoriesVariationsService;

function getCategoriesVariations(int $category_id): array
{
    return (new GetCategoriesVariationsService())($category_id);
}
