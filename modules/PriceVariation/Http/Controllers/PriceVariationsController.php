<?php

namespace Modules\PriceVariation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Http\Controllers\CrudController;
use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;
use Modules\PriceVariation\Http\Requests\PriceVariationRequest;
use Modules\PriceVariation\Services\CreatePriceVariationService;
use Modules\PriceVariation\Services\ManagePriceVariationsService;
use Modules\PriceVariation\Services\UpdatePriceVariationPriceService;

class PriceVariationsController extends CrudController
{
    public function __construct(
        protected PriceVariationsRepositoryInterface $repository
    ){}

    public function index(Request $request): LengthAwarePaginator
    {
        $service = app(ManagePriceVariationsService::class);
        return $service->handle($request);
    }

    public function store(PriceVariationRequest $request,
                          CreatePriceVariationService $createPriceVariationService
    ): array {
        $createPriceVariationService->handle($request);
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        $request = request();
        return $this->repository->firstOrFail([
            'product_id' => $request->get('product_id'),
            'id'         => $id,
        ]);
    }

    public function update($id, PriceVariationRequest $request,
                           UpdatePriceVariationPriceService $updatePriceVariationPriceService
    ): array {
        $updatePriceVariationPriceService->handle($id, $request);
        return ['status' => 'ok'];
    }

    public function byProduct(int $id): array
    {
        return $this->repository->get(['product_id' => $id])->toArray();
    }
}
