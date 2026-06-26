<?php

namespace Modules\Categories\Http\Controllers;

use Modules\Categories\Contracts\SpecificationRepositoryInterface;

class CategorySpecificationsController
{
    public function __invoke(
        int $id,
        SpecificationRepositoryInterface $repository
    )
    {
        return $repository->getCategorySpecifications($id);
    }
}
