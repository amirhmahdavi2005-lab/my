<?php

namespace Modules\Brands\Services;

use Illuminate\Http\Request;
use Modules\Brands\Contracts\BrandRepositoryInterface;

class CreateBrandService
{
    public function __construct(protected BrandRepositoryInterface $repository) {}

    public function handel(Request $request): void
    {
        $data = $request->all();
        if ($request->hasFile('icon')) {
            $data['icon'] = upload_file_manual($request->file('icon'), 'upload');
        }

        $this->repository->create($data);
    }
}
