<?php

namespace Modules\Colors\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\database\factories\ColorFactory;

class Color extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'colors';

    public static $title = 'رنگ';

    protected $guarded = [];

    protected static function searchItems($request): array
    {
        return [
            'name' => ['operator' => 'like', 'value' => $request->get('name')]
        ];
    }
    protected static  function newFactory():Factory
    {
        return ColorFactory::new();
    }
    public static function itemsDetail():array{
        $repo=app(ColorRepositoryInterface::class);
        $colors=$repo->all();
        $list=[];
        foreach ($colors as $color){
            $list[]=[
                'title'=>$color->name,
                'value'=>$color->id
            ];
        }
        return [
            'title'=>'رنگ',
            'list'=>$list,
            'model'=>'\\Modules\\Colors\\Models\\Color'
        ];
    }
}
