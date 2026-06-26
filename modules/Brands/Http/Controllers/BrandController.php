<?php

namespace Modules\Brands\Http\Controllers;

use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Brands\Http\Requests\BrandRequest;
use Modules\Main\Http\Controllers\CrudController;

class BrandController extends CrudController
{
    public function __construct(protected BrandRepositoryInterface $repository) {}

    public function store(BrandRequest $request): array
    {
        $this->repository->create($request->all(), $request->file('icon'));
        return ['status' => 'ok'];
    }

    public function update($id, BrandRequest $request): array
    {
        $this->repository->update($id, $request->all(),
            $request->file('icon'));
        return ['status' => 'ok'];
    }

    public function all()
    {
        return $this->repository->getAll();
    }
}
