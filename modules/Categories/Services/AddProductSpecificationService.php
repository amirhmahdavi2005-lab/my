<?php

namespace Modules\Categories\Services;

use Modules\Categories\Contracts\AddProductSpecificationServiceInterface;
use Modules\Categories\Contracts\ProductSpecificationRepositoryInterface;


class AddProductSpecificationService implements AddProductSpecificationServiceInterface
{
    public function __construct(protected ProductSpecificationRepositoryInterface $repository)
    {

    }

    public function syncSpecifications(int $productId, array $values):void
    {
        $this->repository->deleteByProductId($productId);
        if(!is_array($values)) {
            return;
        }
        $insertData = [];
        foreach ($values as $characteristicId => $value) {
            if(empty($value)) {
                continue;
            }
            if(is_array($value)) {
                foreach ($value as $val => $enabled) {
                    if($enabled) {
                        $insertData[] = [
                            'product_id' => $productId,
                            'characteristic_id' => $characteristicId,
                            'value' => $val,
                        ];
                    }
                }
            }
            else{
                $insertData[] = [
                    'product_id' => $productId,
                    'characteristic_id' => $characteristicId,
                    'value' => $value,
                ];
            }
        }
        $this->repository->insertMany($insertData);
    }
}
