<?php

namespace Modules\Products\Services;

use Modules\Products\Contracts\ProductKeywordsRepositoryInterface;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Contracts\ProductDetailRepositoryInterface;
use Modules\Products\Models\Product;

class ShowProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected ProductDetailRepositoryInterface $detailRepository,
        protected ProductKeywordsRepositoryInterface $keywordRepository
    ) {}

    public function handle(int $id, bool $withVariationParams = false, bool $withVariation = false): array
    {
        $product = $this->productRepository->findForShow($id, $withVariation);

        $this->addOptions($product);
        $this->addTags($product);

        if ($withVariationParams) {
            //$this->addVariationParams($product);
        }

        return $product->toArray();
    }

    protected function addOptions(Product  $product): void
    {
        $options = $this->detailRepository->getDetail($product->id);

        foreach ($options as $key=>$value) {
            $product->setAttribute($key, $value);
        }
    }

    protected function addTags(Product &$product): void
    {
        $tags = $this->keywordRepository->getTagsByProductId($product->id);
        $product->setAttribute('tags', $tags);
    }

    protected function addVariationParams(Product &$product): void
    {
        $variationParams = getCategoriesVariations($product->category_id);
        $product->setAttribute('variation-params', $variationParams);
    }
}
