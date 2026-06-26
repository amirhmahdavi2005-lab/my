<?php

namespace Modules\Categories\Http\Controllers;

use Modules\Categories\Contracts\CategoryRepositoryInterface;

class AllCategoryController
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository){

    }
    public function __invoke():array{
    return $this->categoryRepository->all();
}
}
