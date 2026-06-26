<?php

namespace Modules\Brands\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Main\Repositories\CrudRepository;

class BrandRepository extends CrudRepository implements BrandRepositoryInterface
{
    protected string  $model=Brand::class;
    public function create(array $data, ?UploadedFile $icon): Brand
    {
        if ($icon) {
            $data['icon'] = upload_file_manual($icon, 'upload');
        }
        $brand = new Brand($data);
        $brand->saveOrFail();
        return $brand;
    }

    public function update(int $id, array $data, ?UploadedFile $icon): Brand
    {
        $brand = Brand::findOrFail($id);
        if ($icon) {
            $data['icon'] = upload_file_manual($icon, 'upload');
        } else {
            unset($data['icon']);
        }
        $brand->update($data);
        return $brand;
    }

    public function getAll(): Collection
    {
        return Brand::select([
            'id', 'name', 'english_name', 'icon', 'categories'])->get();
    }

    public function findByEnglishName(string $englishName): ?Brand
    {
        return Brand::where('english_name', $englishName)->first();
    }
    public function latest($column)
    {
        return Brand::latest($column)->first();
    }
    public function exists(array $condition){
        return Brand::where($condition)->exists();
    }
    public function countTrashedCategoriesByText(string $text): int
    {
        return Brand::onlyTrashed()
            ->where(function ($q) use ($text) {
                $q->where('name', 'like', "%$text%");
            })
            ->count();
    }
    public function first(array $condition):?Brand{
        return Brand::where($condition)->first();
    }
    public function getByArrayId(array $ids): array
    {
        return Brand::whereIn('id', $ids)->get()->all();
    }


}
