<?php

namespace Modules\Categories\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Categories\Models\Category;
use Modules\Categories\Repositories\CategoryRepository;
use Modules\Categories\Services\AddSpecificationsService;

class SpecificationsController
{
    public function store(int $category_id, Request $request ,
    AddSpecificationsService $addSpecificationsService):array{
        app(CategoryRepository::class)->find($category_id);
        $addSpecificationsService->handel(
            $category_id,
            $request->all(),
        );

        return ['status'=>'ok'];

    }
    public function destroy(){

    }
}
