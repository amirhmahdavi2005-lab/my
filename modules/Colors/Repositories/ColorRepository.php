<?php

namespace Modules\Colors\Repositories;

use Illuminate\Support\Collection;
use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\Models\Color;
use Modules\Main\Repositories\CrudRepository;

class ColorRepository extends CrudRepository implements ColorRepositoryInterface
{
    protected string $model=Color::class;

    public function create(array $data): Color
    {
        $color = new Color($data);
        $color->saveOrFail();
        return $color;
    }

    public function update(int $id, array $data): Color
    {
        $color = Color::findOrFail($id);
        $color->update($data);
        return $color;
    }

    public function all(): Collection
    {
        return Color::all();
    }

    public function exists(array $condition)
    {
        return Color::where($condition)->exists();
    }

    public function countForTesting(string $name): int
    {
        return Color::onlyTrashed()
            ->where('name','like','%'.$name.'%')
            ->count();
    }

    public function first(array $condition){
        return Color::where($condition)->first();
    }

    public function firstOrCreate(array $condition,array $data):Color{
        if(!array_key_exists('code',$data)){
            $data['code']='#FFFFFF';
        }
        return  Color::firstOrCreate($condition,$data);
    }
}
