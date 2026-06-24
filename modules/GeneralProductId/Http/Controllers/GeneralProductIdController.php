<?php

namespace Modules\GeneralProductId\Http\Controllers;

use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;
use Modules\Main\Http\Controllers\CrudController;
use Modules\GeneralProductId\Http\Requests\GeneralIdRequest;
use Modules\GeneralProductId\Models\GeneralProductId;

class GeneralProductIdController  extends CrudController{

    public function __construct(
        protected GeneralProductIdRepositoryInterface $repository
    ){}

    public function store(GeneralIdRequest $request):array{
        $this->repository->create($request->all());
        return ['status'=>'ok'];
    }

    public function update($id,GeneralIdRequest $request):array{
        $this->repository->update($id,$request->all());
        return ['status'=>'ok'];
    }
}
