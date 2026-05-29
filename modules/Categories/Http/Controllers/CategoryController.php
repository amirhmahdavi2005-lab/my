<?php

namespace Modules\Categories\Http\Controllers;


use Modules\Categories\Contracts\StoreCategoryServiceInterface;
use Modules\Categories\Contracts\UpdateCategoryServiceInterface;
use Modules\Categories\Http\Requests\CategoryRequest;
use Modules\Categories\Repositories\CategoryRepository;
use Modules\Categories\Services\StoreCategoryService;
use Modules\Main\Http\Controllers\CrudController;

class CategoryController extends CrudController
{

    public function __construct(
        protected CategoryRepository $repository,
    )
    {}


    public function store(CategoryRequest $request):array
    {
        app(StoreCategoryServiceInterface::class)->handel($request);
        return ['status'=>'ok'];
}

    public function update(CategoryRequest $request, $id): array
    {
        app(UpdateCategoryServiceInterface::class)
            ->update($id, $request);

        return ['status' => 'ok'];
    }

}
