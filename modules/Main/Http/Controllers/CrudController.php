<?php

namespace Modules\Main\Http\Controllers;

use Illuminate\Http\Request;

abstract class CrudController
{
    public function index(Request $request)
    {
        return $this->repository->index($request);
    }
public function destroy($id): array
{
    $this->repository->delete($id);
    return['status'=>'ok'];
}
    public function show($id)
    {
      return $this->repository->find($id);
    }

    public function restore($id):array
    {
        $this->repository->restore($id);
        return ['status'=>'ok'];
    }

}
