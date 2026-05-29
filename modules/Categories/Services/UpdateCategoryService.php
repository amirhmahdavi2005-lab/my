<?php

namespace Modules\Categories\Services;

use Modules\Categories\Contracts\UpdateCategoryServiceInterface;
use Modules\Categories\Http\Requests\CategoryRequest;
use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;

class UpdateCategoryService implements UpdateCategoryServiceInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected CategoryKeywordRepositoryInterface $keywordRepository
    ) {}

    public function update(int $id, CategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = replaceSpace($data['ename'] ?? '');

        if ($request->hasFile('pic')) {
            $data['image'] = upload_file_manual(
                $request->file('pic'),
                'upload'
            );
        }

        return $this->categoryRepository->update($id, $data);
    }
}
