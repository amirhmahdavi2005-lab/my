<?php

namespace Modules\PriceVariation\Services;

use Maatwebsite\Excel\Facades\Excel;
use Modules\PriceVariation\Contracts\PriceVariationExportRepositoryInterface;
use Modules\PriceVariation\Exports\PricesExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportPriceVariationsService
{
    public function __construct(
        protected PriceVariationExportRepositoryInterface $repository
    ) {}

    public function handle(?int $categoryId, ?int $brandId): ?BinaryFileResponse
    {
        $variations = $this->repository->getExportData($categoryId, $brandId);

        if ($variations->count() > 0) {
            return Excel::download(new PricesExport($variations), 'variations.xlsx');
        }

        return null;
    }
}
