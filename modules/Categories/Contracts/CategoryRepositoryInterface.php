<?php

namespace Modules\Categories\Contracts;

use Modules\Categories\Models\Category;

interface CategoryRepositoryInterface
{
    public function create(array $data): Category;

    public function latest(string $column);

    public function update(int $id, array $data);

    public function countTrashedCategoriesByText(string $text): int;

    public function all(): array;

    public function first(int $id);
    public function pluckChildrenIds(array $parentIds, array $excludeIds = []): array;
}
