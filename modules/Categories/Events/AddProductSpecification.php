<?php

namespace Modules\Categories\Events;

use Modules\Categories\Contracts\AddProductSpecificationServiceInterface;



class AddProductSpecification
{
    public function handel($product):void
    {
        $specService = app(AddProductSpecificationServiceInterface::class);
        $request = request();
        $values = $request->input('specification' , [] );
        $specService->syncSpecifications($product->id, $values);
    }
}
