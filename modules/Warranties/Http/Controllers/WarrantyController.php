<?php

namespace Modules\Warranties\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Main\Http\Controllers\CrudController;
use Modules\Warranties\Contracts\WarrantyRepositoryInterface;
use Modules\Warranties\Http\Requests\WarrantyRequest;
use Modules\Warranties\Models\Warranty;

class WarrantyController extends CrudController
{

    public function __construct(
        protected WarrantyRepositoryInterface $repository)
    {}

    public function store(WarrantyRequest $request): array
    {
        $this->repository->store($request->all());
        return ['status' => 'ok'];
    }

    public function update($id, WarrantyRequest $request): array
    {
        $warranty = $this->repository->find($id);
        $this->repository->update($warranty, $request->all());
        return ['status' => 'ok'];
    }
}
