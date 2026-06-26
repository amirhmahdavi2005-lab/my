<?php

namespace Modules\Warranties\Contracts;

use Illuminate\Support\Collection;
use Modules\Main\Contracts\CrudRepositoryInterface;
use Modules\Warranties\Models\Warranty;

interface WarrantyRepositoryInterface extends CrudRepositoryInterface
{
    public function store(array $data): Warranty;
    public function update(Warranty $warranty, array $data): Warranty;

    public function exists(array $condition);

    public function countForTesting(string $name):int;

    public function all(): Collection;
}
