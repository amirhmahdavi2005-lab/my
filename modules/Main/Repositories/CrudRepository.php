<?php

namespace Modules\Main\Repositories;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Contracts\CrudPaginationInterface;
use Modules\Main\Contracts\CrudRepositoryInterface;

class CrudRepository implements CrudRepositoryInterface
{

    public function index(Request $request): LengthAwarePaginator
    {
        $paginationRepo = new CrudPaginationRepository(
            filters:[
                new CrudPaginationSoftDeleteFilter(),
                new CrudPaginationFilter(),
            ],
            ordering:new CrudPaginationOrder()
        );
       return $paginationRepo->paginate($request, $this->model);
    }

    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    public function delete($id)
    {
        $row = $this->findWithTrashed($id);
              if (is_null($row->deleted_at)) {
                 $row->delete();
              }
              else{
                  if(!property_exists($this->model, 'disableForceDelete')){
                      $row->forceDelete();
                  }
              }
    }

    public function restore($id)
    {
        $row = $this->findWithTrashed($id);
        $row->restore();
    }

    public function findWithTrashed($id)
    {
        $where = ['id' => $id];

        if (method_exists($this->model, 'findWhere')) {
            $where = array_merge($where, $this->model->findWhere());
        }

        $userSoftDelete = in_array(
            'Illuminate\Database\Eloquent\SoftDeletes',
            class_uses($this->model)
        );

        if($userSoftDelete) {
            return $this->model::where($where)->withTrashed()->firstOrFail();
        } else {
            return $this->model::where($where)->firstOrFail();
        }
    }



}


