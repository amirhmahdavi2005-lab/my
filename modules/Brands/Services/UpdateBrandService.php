<?php

namespace Modules\Brands\Services;

use Illuminate\Http\Request;
use Modules\Brands\Contracts\BrandRepositoryInterface;

class UpdateBrandService
{
    public function __construct(protected BrandRepositoryInterface $repository) {}

    public function handel(int $id, Request $request): void
    {
        $data = $request->all();
        if ($request->hasFile('icon')) {
            $data['icon'] = upload_file_manual($request->file('icon'), 'upload');
        }

        $this->repository->update($id, $data);
    }
}
