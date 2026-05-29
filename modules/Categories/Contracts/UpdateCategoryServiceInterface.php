<?php

namespace Modules\Categories\Contracts;

use Modules\Categories\Http\Requests\CategoryRequest;

interface UpdateCategoryServiceInterface
{
    public function update(int $id, CategoryRequest $request);
}
