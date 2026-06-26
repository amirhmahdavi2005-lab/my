<?php

namespace Modules\Warranties\Repositories;


use Illuminate\Support\Collection;
use Modules\Main\Repositories\CrudRepository;
use Modules\Warranties\Contracts\WarrantyRepositoryInterface;
use Modules\Warranties\Models\Warranty;

class WarrantyRepository  extends CrudRepository implements WarrantyRepositoryInterface
{
    protected string $model=Warranty::class;

    public function store(array $data): Warranty
    {
        $warranty = new Warranty($data);
        $warranty->saveOrFail();
        return $warranty;
    }

    public function update(Warranty $warranty, array $data): Warranty
    {
        $warranty->update($data);
        return $warranty;
    }

    public function exists(array $condition)
    {
        return Warranty::where($condition)->exists();
    }

    public function countForTesting(string $name): int
    {
        return Warranty::onlyTrashed()
            ->where('name','like','%'.$name.'%')
            ->count();
    }

    public function all(): Collection
    {
        return Warranty::all();
    }
}
