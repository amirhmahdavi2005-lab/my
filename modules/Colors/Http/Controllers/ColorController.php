<?php

namespace Modules\Colors\Http\Controllers;

use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\Http\Requests\ColorRequest;
use Modules\Colors\Models\Color;
use Modules\Main\Http\Controllers\CrudController;

class ColorController extends CrudController
{
    public function __construct(
        protected ColorRepositoryInterface $repository
    ) {}

    public function store(ColorRequest $request): array
    {
        $this->repository->create($request->all());
        return ['status' => 'ok'];
    }

    public function update($id, ColorRequest $request): array
    {
        $this->repository->update($id, $request->all());
        return ['status' => 'ok'];
    }

    public function all()
    {
        return $this->repository->all();
    }
}
