<?php

namespace Modules\Categories\Contracts;

interface SpecificationRepositoryInterface
{
    public function update(int $id, array $data): void;

    public function insert(array $data): int;

    public function insertChild(array $data): void;

    public function getRootWithChildren(array $categoriesId);

    public function deleteWithChildren(int $id): void;

    public function getCategorySpecifications(int $categoryId);
}
