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
        return Category::latest($column)->first();
    }

    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);

        $category->update($data);

        return $category;
    }

    public function countTrashedCategoriesByText(string $text):int
    {
        return Category::onlyTrashed()->Where('name','like','%'.$text.'%')->orWhere('ename','like','%'.$text.'%')->count();
    }
}
