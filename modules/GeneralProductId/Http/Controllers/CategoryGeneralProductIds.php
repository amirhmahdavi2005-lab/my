<?php

namespace Modules\GeneralProductId\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;

class CategoryGeneralProductIds
{
    public function __construct(
        protected GeneralProductIdRepositoryInterface $repository
    ){}

    public function __invoke($categoryId):Collection{
        return $this->repository->getByCategoriesId(
            getParentCategoriesId($categoryId)
        );
    }
}
