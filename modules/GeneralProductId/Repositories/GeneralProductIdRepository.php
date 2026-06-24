<?php

namespace Modules\GeneralProductId\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Categories\Models\Category;
use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;
use Modules\GeneralProductId\Models\GeneralProductId;
use Modules\Main\Repositories\CrudRepository;

class GeneralProductIdRepository extends CrudRepository implements GeneralProductIdRepositoryInterface
{
    protected string $model='Modules\GeneralProductId\Models\GeneralProductId';

    public function create(array $data):bool
    {
        $generalId=new GeneralProductId($data);
        return $generalId->saveOrFail();
    }

    public function update(int $id,array $data):void
    {
        $generalId=GeneralProductId::findOrFail($id);
        $generalId->update($data);
    }

    public function getByCategoriesId(array $ids):Collection
    {
        return GeneralProductId::whereIn('category_id',$ids)
            ->select(['id','title','general_id'])
            ->get();
    }

    public function exists(array $condition)
    {
        return GeneralProductId::where($condition)->exists();
    }

    public function latest($column='id')
    {
        return GeneralProductId::latest($column)->first();
    }
}
