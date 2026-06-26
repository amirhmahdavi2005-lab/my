<?php

namespace Tests\Feature\Categories;


use Illuminate\Support\Str;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Contracts\SpecificationRepositoryInterface;
use Modules\categories\Models\Specifications;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\products\Models\Product;
use Tests\TestCase;

class ProductSpecificationTest extends TestCase
{
    public function test_add_specifications(): void{
        $product=app(ProductRepositoryInterface::class)->latest();
        if($product){
            $category=app(CategoryRepositoryInterface::class)->latest('id');
            $specificationRepo=app(SpecificationRepositoryInterface::class);
            $request=request();
            $specifications=$specificationRepo->getRootWithChildren([$category->id]);
            $data=[];
            foreach ($specifications as $specification){
                $values=[];
                if(sizeof($specification->childs)>0){
                    foreach ($specification->childs as $key=>$value){
                        $values[$value->id]=($key % 2)==0;
                    }
                }
                else{
                    $values=Str::random(10);
                }
                $data[$specification->id]=$values;
            }
            $this->assertGreaterThan(0,sizeof($data));
            $request->merge([
                'specifications'=>$data
            ]);
            runEvent('product.updated',$product);

            $this->assertDatabaseHas('products__specifications',[
                'product_id'=>$product->id
            ]);
        }
    }
}
