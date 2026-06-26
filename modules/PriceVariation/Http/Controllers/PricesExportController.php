<?php

namespace Modules\PriceVariation\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\PriceVariation\Exports\PricesExport;
use Modules\PriceVariation\Models\PriceVariation;

class PricesExportController
{
    public function __invoke(Request $request)
    {
        $categoryId = $request->post('category_id');
        $brandId = $request->post('brand_id');

        $productIds = $this->getFilteredProductIds($brandId, $categoryId);

        if ($productIds->isEmpty()) {
            return response()->json(['message' => 'هیچ محصولی یافت نشد.'], 204);
        }

        $variations = $this->getVariations($productIds,$request);

        if ($variations->count()==0) {
            return response()->json(['message' => 'هیچ تنوع قیمتی یافت نشد.'], 204);
        }

        return  Excel::download(
            new PricesExport($variations),
            'prices.xlsx'
        );
    }

    private function getFilteredProductIds(?int $brandId, ?int $categoryId){
        return getActionQuery('product:query', function ($query) use ($brandId, $categoryId) {
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }

            if ($categoryId) {
                $categoryIds = getChildCategoriesId($categoryId);
                $query->whereIn('category_id', $categoryIds);
            }

            return $query->pluck('id');
        });
    }

    private function getVariations($productIds,$request)
    {
        $variations=PriceVariation::whereIn('product_id', $productIds)
            ->with(['product', 'param1', 'param2']);
        if($request->get('product_id')){
            $variations=$variations->where('product_id',replaceFaNumber($request->get('product_id')));
        }
        $variations=runEvent('prices-variations:query',$variations,true);

        return $variations->paginate(200);

    }

}
