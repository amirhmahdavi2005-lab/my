<?php

namespace Modules\Warranties\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Warranties\Contracts\WarrantyRepositoryInterface;
use Modules\Warranties\database\factories\WarrantyFactory;

class Warranty extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'warranties';
    protected $guarded = [];

    public static function searchItems($request):array{
        return [
            'name'=>['operator'=>'like','value'=>$request->get('name')]
        ];
    }

    protected $hidden=['created_at','updated_at'];

    protected static function newFactory():Factory{
        return WarrantyFactory::new();
    }
    public static function itemsDetail():array{
        $warranties=app(WarrantyRepositoryInterface::class)->all();
        $list=[];
        foreach ($warranties as $warranty){
            $list[]=[
                'title'=>$warranty->name,
                'value'=>$warranty->id
            ];
        }
        return [
            'title'=>'گارانتی',
            'list'=>$list,
            'model'=>'\\Modules\\Warranties\\Models\\Warranty'
        ];
    }
}


