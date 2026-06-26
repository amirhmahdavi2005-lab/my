<?php

namespace Modules\PriceVariation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PriceVariation\Services\ExportPriceVariationsService;

class PricesExportController extends Controller
{
    public function __construct(
        protected ExportPriceVariationsService $service
    ) {}

    public function __invoke(Request $request)
    {
        $categoryId = $request->post('category_id');
        $brandId = $request->post('brand_id');

        return $this->service->handle($categoryId, $brandId);
    }
}
