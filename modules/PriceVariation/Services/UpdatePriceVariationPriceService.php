<?php

namespace Modules\PriceVariation\Services;

use Illuminate\Http\Request;

use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;

class UpdatePriceVariationPriceService
{
    public function __construct(
        protected PriceVariationsRepositoryInterface $repository
    ){}

    public function handle(int $id,Request $request):void
    {
        $request=request();
        $data=$request->all();
        $this->repository->firstOrFail(['id'=>$id,'product_id'=>$request->get('product_id')]);
        $arr=[
            'param1_type',
            'param1_id',
            'param2_type',
            'param2_id'
        ];
        foreach ($arr as $value){
            if(array_key_exists($value,$data)){
                unset($data['value']);
            }
        }
        if(array_key_exists('status',$data)){
            $data['status']=($data['status']=='true') ? 1 : 0;
        }
        $this->repository->update($id,$data);
    }
}
