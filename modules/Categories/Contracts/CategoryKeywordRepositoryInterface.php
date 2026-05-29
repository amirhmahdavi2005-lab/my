<?php

namespace Modules\Categories\Contracts;

interface CategoryKeywordRepositoryInterface
{
    public function createKeyword(int $categoryId, array $keywords);
    public function deleteByCategoryId(int $categoryId);
    public function arrayList(int $categoryId);
}
