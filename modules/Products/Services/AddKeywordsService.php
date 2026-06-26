<?php

namespace Modules\Products\Services;

use Illuminate\Http\Request;
use Modules\Products\Contracts\ProductKeywordsRepositoryInterface;
use Modules\Products\Models\ProductKeyword;
use Modules\Products\Repositories\ProductKeywordsRepository;

class AddKeywordsService
{
    public function __construct(
        protected  ProductKeywordsRepositoryInterface $repository
    ){}

    public function handle($product):void
    {
        $request=request();
        $this->repository->destroy($product->id);
        $keywords=$request->get('keywords');
        $array=explode(',',$keywords);
        foreach ($array as $value){
            if(!empty($value)){
                $this->repository->create([
                    'product_id'=>$product->id,
                    'tag'=>$value
                ]);
            }
        }
    }
}
