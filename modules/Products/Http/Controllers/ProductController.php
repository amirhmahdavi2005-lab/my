<?php

namespace Modules\Products\Http\Controllers;

use Modules\Main\Http\Controllers\CrudController;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Http\Requests\ProductRequest;
use Modules\Products\Actions\ShowProduct;
use Modules\Products\Services\CreateProductService;
use Modules\Products\Services\ShowProductService;
use Modules\Products\Services\UpdateProductService;

class ProductController extends CrudController
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ){}

    public function store(ProductRequest $request,
                          CreateProductService $createProductService):array
    {
        $createProductService->handle($request->all(),$request->user());
        return ['status' => 'ok'];
    }

    public function show($id): array
    {
        $showProductService=app(ShowProductService::class);
        $request=request();
        return $showProductService->handle(
            $id,
            $request->get('variation-params')=='true'
        );
    }

    public function update($id,ProductRequest $request,
                           UpdateProductService $updateProductService):array{
        $updateProductService->handle($request->all(),$id,$request->user());
        return ['status' => 'ok'];
    }
}
