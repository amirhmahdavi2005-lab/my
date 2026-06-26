<?php

namespace Modules\PriceVariation\Services;

use Illuminate\Pagination\LengthAwarePaginator;

use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;

class ManagePriceVariationsService
{
    public function __construct(
        protected PriceVariationsRepositoryInterface $repository
    ){}

    public function handle($request):LengthAwarePaginator
    {
        $data['product_id']=$request->get('product_id');
        if(array_key_exists('page',$data)){
            unset($data['page']);
        }
        if($request->get('trashed')=='true'){
            $data['trashed']=true;
        }
        return $this->repository->pagination($data);
    }
}
