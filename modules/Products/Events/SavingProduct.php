<?php

namespace Modules\Products\Events;

use Modules\Products\Contracts\ProductDetailRepositoryInterface;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;

class SavingProduct
{


        protected array $options=[
        'general_product_id',
        'height',
        'length',
        'origin',
        'strengths',
        'weaknesses',
        'weight',
        'width',
        'product_dimensions',
        'barcode',
        'barcode_type'
    ];



    public function handle(Product $product){
                $repository = app(ProductRepositoryInterface::class);
            $request=request();
            $repository->destroy($product->id,$this->options);

            foreach($this->options as $option){
                if($request->has($option)){
                    $repository->create([
                        'product_id' => $product->id,
                        'name' => $option,
                        'value' => $request->get($option)
                    ]);
                }
            }
        }

}
