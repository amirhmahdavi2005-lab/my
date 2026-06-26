<?php

namespace Modules\Categories\Repositories;

use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;
use Modules\Main\Repositories\CrudRepository;

class CategoryRepository extends CrudRepository implements CategoryRepositoryInterface
{
    protected string $model = Category::class;

    public function create(array $data): Category
    {
        $category = new Category($data);
        $category->saveOrFail();

        return $category;
    }

    public function latest(string $column)
    {
        return Category::query()->latest($column)->first();
    }

    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function countTrashedCategoriesByText(string $text): int
    {
        return Category::onlyTrashed()
            ->where(function ($q) use ($text) {
                $q->where('name', 'like', "%{$text}%")
                    ->orWhere('ename', 'like', "%{$text}%");
            })
            ->count();
    }

    public function all(): array
    {
        return Category::query()->get()->toArray();
    }

    public function first(int $id)
    {
        return Category::find($id);
    }

    public function getCategoryById(int $id)
    {
        return Category::find($id);
    }

    public function getByArrayId(array $ids): array
    {
        return Category::whereNull('url')
            ->whereIn('id', $ids)
            ->get()
            ->all();
    }

    public function pluckChildrenIds(array $parentIds, array $excludeIds = []): array
    {
        return Category::whereIn('parent_id', $parentIds)
            ->whereNotIn('id', $excludeIds)
            ->pluck('id')
            ->toArray();
    }
}
