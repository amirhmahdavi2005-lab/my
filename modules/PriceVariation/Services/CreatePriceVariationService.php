<?php

namespace Modules\PriceVariation\Services;

use Illuminate\Http\Request;
use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;

class CreatePriceVariationService
{
    public function __construct(
        protected  PriceVariationsRepositoryInterface $repository
    ){}

    public function handle(Request $request,$sellerId=0):void
    {
        $data=$request->all();
        $data['status']=($data['status']=='true') ? 1 : 0;
        if($sellerId){
            $data['seller_id']=$sellerId;
        }
        $this->repository->create($data);
    }
}
