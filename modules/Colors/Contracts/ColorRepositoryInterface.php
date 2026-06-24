<?php

namespace Modules\Colors\Contracts;
use Illuminate\Support\Collection;
use Modules\Colors\Models\Color;
use Modules\Main\Contracts\CrudRepositoryInterface;

interface ColorRepositoryInterface extends CrudRepositoryInterface
{
    public function create(array $data): Color;

    public function update(int $id, array $data): Color;

    public function all(): Collection;

    public function exists(array $condition);

    public function countForTesting(string $name):int;

    public function first(array $condition);

    public function firstOrCreate(array $condition,array $data):Color;

}

