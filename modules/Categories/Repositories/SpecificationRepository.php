<?php

namespace Modules\Categories\Repositories;

use Modules\Categories\Contracts\SpecificationRepositoryInterface;
use Modules\Categories\Models\Specifications;

class SpecificationRepository implements SpecificationRepositoryInterface
{

    public function update(int $id, array $data): void
    {
        Specifications::where('id', $id)->update($data);
    }

    public function insert(array $data): int
    {
        return Specifications::insertGetId($data);
    }

    public function insertChild(array $data): void
    {
        Specifications::create($data);
    }

    public function getRootWithChildren(array $categoriesId)
    {
        return Specifications::query()
            ->where('parent_id', 0)
            ->whereIn('category_id', $categoriesId)
            ->with('childs')
            ->get();
    }

    public function deleteWithChildren(int $id): void
    {
        Specifications::where('id', $id)->delete();

        Specifications::where('parent_id', $id)->delete();
    }
    public function getCategorySpecifications(int $categoryId)
    {
        return Specifications::where('parent_id', 0)
            ->where('category_id', $categoryId)
            ->with('childs')
            ->get();
    }
}
