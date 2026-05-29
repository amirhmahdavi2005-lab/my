<?php

namespace Modules\Main\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Contracts\CrudPaginationInterface;

class CrudPaginationRepository implements CrudPaginationInterface
{
    protected Request $request;
    protected Builder $query;
    protected string $modelClass;

    public function paginate(Request $request, string $modelClass): LengthAwarePaginator
    {
        $this->request = $request;
        $this->modelClass = $modelClass;
        $this->query=$modelClass::query();
        $this->applySoftDeletes();
        $this->applySearechFilters();
        $this->applyOrdering();
        $paginator = $this->query->paginate(10);

        if (property_exists($modelClass, 'VisibleForPagination')) {
            $paginator-> data = $paginator-> makeVisible($modelClass::$visibleForPagination);
        }
        return $paginator;
    }

    protected function applySoftDeletes(): void
    {
        if(in_array('Illuminate\Database\Eloquent\SoftDeletes' , class_uses($this->modelClass))
        && $this->request->get('trashed')=='true'){
            $this->query->onlyTrashed();
        }
    }
    protected function applySearechFilters(): void{
        if(method_exists($this->modelClass, 'searchItems')){
            $filterItems = $this->modelClass::searchItems($this->request);
            foreach($filterItems as $key => $item){
                $this->addFilter($key,$item);
            }
        }
    }
    public function addFilter($key,$item):void{
        if(is_array($item)){
            $operator=$item['operator']??'=';
            $value=$item['value']?? null;
            if(!is_null($value)&& $value !=='null'){
                if($operator== 'like'){
                  $this->query->where(function($query) use($key,$item,$value){
                      $query->where($key,'like','%'.$value.'%');
                      if(!empty($item['orWhereColumn'])) {
                          $query->orWhere($item['orWhereColumn'], 'like', '%'. $value. '%');
                      }
                  });
                }
                else{
                    $this->query->where($key,$operator,$value);
                }
        }
        elseif (is_callable($item)){
            $this->query = $item($this->query);
        }
        }
}
protected function applyOrdering(): void{
    $orderBy = property_exists($this->modelClass, 'orderBy')?$this->modelClass->orderBy:'id';
    $this->query->orderBy($orderBy,'desc');}
}
