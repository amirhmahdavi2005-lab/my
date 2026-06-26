<?php

namespace Modules\Brands\Contracts;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Brands\Models\Brand;
use Modules\Main\Contracts\CrudRepositoryInterface;

interface BrandRepositoryInterface extends CrudRepositoryInterface
{
    public function create(array $data, ?UploadedFile $icon): Brand;
    public function update(int $id, array $data, ?UploadedFile $icon): Brand;
    public function getAll(): Collection;
    public function findByEnglishName(string $englishName): ?Brand;
    public function latest($column);
    public function exists(array $condition );
    public function countTrashedCategoriesByText(string $text): int;

    public function first(array $condition):?Brand;

    public function getByArrayId(array $ids):array;

}
