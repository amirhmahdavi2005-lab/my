<?php

namespace Modules\Categories\Repositories;

use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Models\CategoryKeyword;

class CategoryKeywordRepository implements CategoryKeywordRepositoryInterface
{
    public function createKeyword(int $categoryId, array $keywords)
    {
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (!empty($keyword)) {
                CategoryKeyword::create(['category_id' => $categoryId, 'tag' => $keyword]);
            }
        }
    }

    public function deleteByCategoryId(int $categoryId)
    {
        CategoryKeyword::where('category_id', $categoryId)->delete();
    }

    public function arrayList(int $categoryId)
    {
        return CategoryKeyword::where('category_id', $categoryId)->pluck('tag')->toArray();
    }
}

