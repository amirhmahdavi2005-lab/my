<?php

namespace Modules\Categories\Services;


use Illuminate\Http\Request;
use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;

class StoreCategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected CategoryKeywordRepositoryInterface $keywordRepository){}


public function handel(Request $request):Category{
    $data = $request->all();
    $data['slug'] = replaceSpace($data['ename'] ?? '');
    if ($request->hasFile('pic')) {
        $data['image'] = upload_file_manual($request->file('pic'), 'upload');
    }
    $data['parent_id'] = $data['parent_id'] ?? 0;
    $category = $this->categoryRepository->create($data);
    $keywords=explode(',',$data['keywords']??'');
    $this->keywordRepository->createKeyword($category->id,$keywords);

    return $category;
}}
