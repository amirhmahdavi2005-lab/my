<?php

namespace Modules\Products\Repositories\Filters;

class AdminProductSearchFiltersProvider
{
    public function apply($request) : array
    {
        return [
            'product_count' => fn($query) => $this->applyProductCountFilter($query, $request),
            'title' => [
                'operator' => 'like',
                'value' => $request->get('title'),
                'orWhereColumn' => 'en_title'
            ],
            'id'=>['operator'=>'=','value'=>replaceFaNumber($request->get('product_id'))],
            'variation' => fn($query) => $this->withVariation($query),
            'category' => fn($query) => $this->applyCategoryFilter($query, $request),
            'brand' => fn($query) => $this->applyBrandFilter($query, $request),
            'status' => fn($query) => $this->applyStatusFilter($query, $request),
            'sortBy' => fn($query) => $this->applySorting($query, $request)
        ];
    }

    protected function applyProductCountFilter($query, $request)
    {
        if ($request->get('max_product_count')) {
            $query->where('product_count', '<=', intval($request->get('max_product_count')));
        }

        if ($request->get('min_product_count')) {
            $query->where('product_count', '>=', intval($request->get('min_product_count')));
        }

        return runEvent('admin-search-products', $query, true);
    }

    protected function withVariation($query)
    {
        return $query->with('variation')->withCount('variations');
    }

    protected function applyCategoryFilter($query, $request)
    {
        if ($request->get('category_id')) {
            $categoriesId = getChildCategoriesId($request->get('category_id'));
            $query->whereIn('category_id', $categoriesId);
        }

        return $query->with('category');
    }

    protected function applyBrandFilter($query, $request)
    {
        if ($request->get('brand_id')) {
            $query->where('brand_id', $request->get('brand_id'));
        }
        return $query;
    }

    protected function applySorting($query, $request)
    {
        if ($request->get('sortBy')) {
            $ar = explode('-', $request->get('sortBy'));
            if (count($ar) === 2) {
                $query = $query->orderBy($ar[0], $ar[1]);
            }
        }

        return $query;
    }

    protected function applyStatusFilter($query, $request)
    {
        if ($request->has('status') && $request->get('status')!='') {
            $query = $query->where('status',intval($request->get('status')));
        }
        return $query;
    }
}
