<?php

namespace Modules\PriceVariation\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Repositories\CrudRepository;
use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;
use Modules\PriceVariation\Models\PriceVariation;

class PriceVariationsRepository extends CrudRepository implements PriceVariationsRepositoryInterface
{
    protected string $model = PriceVariation::class;

    public function checkForUnique($conditions,int $exceptId): bool
    {
        $query=PriceVariation::query();
        $query->where($conditions);
        $query->whereNot('id',$exceptId);
        $query=runEvent('price-variation:unique-review',$query,true);
        return $query->exists();
    }
    public function create(array $data)
    {
        $variation=new PriceVariation($data);
        $variation=runEvent('price-variation:creating',$variation,true);
        return $variation->saveOrFail();
    }
    public function latest(string $column='id')
    {
        return PriceVariation::latest($column)->first();
    }

    public function exists(array $condition)
    {
        return PriceVariation::where($condition)->exists();
    }
    public function first(array $condition):?PriceVariation
    {
        return  PriceVariation::where($condition)->first();
    }

    public function firstOrFail(array $condition):PriceVariation
    {
        return  PriceVariation::where($condition)->firstOrFail();
    }
    public function update(int $id, array $data):void
    {
        PriceVariation::where('id',$id)
            ->update($data);
    }
    public function get(array $conditions)
    {
        return PriceVariation::where($conditions)->get();
    }

    public function pagination($data): LengthAwarePaginator
    {
        $onlyTrashed=false;
        if(array_key_exists('trashed',$data)){
            unset($data['trashed']);
            $onlyTrashed=true;
        }
        //seller
        $variations=PriceVariation::where($data)
            ->with(['param1','param2']);
        if($onlyTrashed){
            $variations->onlyTrashed();
        }
        $variations=runEvent('variations:select-query',$variations,true);
        return $variations->paginate(10);
    }

}
