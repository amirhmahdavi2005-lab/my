<?php

namespace Modules\Categories\Contracts;

use Modules\Categories\Models\Category;
use Modules\Main\Contracts\CrudRepositoryInterface;


interface CategoryRepositoryInterface extends CrudRepositoryInterface
{
    public function create(array $data):Category;
    public function latest(string $column);
    public function update(int $id, array $data);

    public function countTrashedCategoriesByText(string $text):int;
}
