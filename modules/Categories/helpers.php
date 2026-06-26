<?php
use \Modules\Categories\Models\Category;
use \Illuminate\Support\Facades\Cache;
use \Modules\Categories\Contracts\CategoryRepositoryInterface;
function getParentCategoriesId($categoryId):array{
    $array=[];
    $category=Category::find($categoryId);
    if($category){
        $array[]=$category->id;
    }
    for ($i=0;$i<4;$i++)
    {
        if($category){
            $category=Category::where('id',$category->parent_id)
                ->first();
            if($category){
                $array[]=$category->id;
            }
        }
    }
    return $array;
}

function getChildCategoriesId($categoryId):array{
    $minute=now()->addMinutes(60);
    return Cache::remember('child-categories-'.$categoryId,$minute,function () use ($categoryId){
        $repository=app(CategoryRepositoryInterface::class);
        $array=[];
        $category=$repository->getCategoryById($categoryId);
        if($category){
            $array=[$category->id];
            for ($i=0;$i<3;$i++){
                $categories=$repository->pluckChildrenIds($array,$array);
                $array=array_merge($array,$categories);
            }
        }
        return $array;
    });
    
}

