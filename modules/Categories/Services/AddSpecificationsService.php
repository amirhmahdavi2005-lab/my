<?php

namespace Modules\Categories\Services;

use Modules\Categories\Contracts\SpecificationRepositoryInterface;

class AddSpecificationsService
{
    public function __construct(
        protected SpecificationRepositoryInterface $repository
    ) {}

    public function handel(int $category_id, array $data): void
    {
        $technicalSpecifications =
            $data['technical_specifications'] ?? [];

        $position = 0;

        foreach ($technicalSpecifications as $value) {

            if (!empty($value['name'])) {

                if (array_key_exists('id', $value)) {

                    $id = $value['id'];

                    $this->repository->update($id, [
                        'position' => $position,
                        'name' => $value['name'],
                        'important' => $this->isImportant($value),
                    ]);

                } else {

                    $id = $this->repository->insert([
                        'position' => $position,
                        'category_id' => $category_id,
                        'name' => $value['name'],
                        'parent_id' => 0,
                        'important' => $this->isImportant($value),
                    ]);
                }

                $this->addChilds(
                    $id,
                    $value['childs'] ?? [],
                    $category_id
                );

                $position++;
            }
        }
    }

    protected function addChilds(
        int $parent_id,
        array $childs,
        int $category_id
    ): void
    {
        $position = 0;

        foreach ($childs as $child) {

            if (!empty($child['name'])) {

                if (array_key_exists('id', $child)) {

                    $this->repository->update($child['id'], [
                        'name' => $child['name'],
                        'position' => $position,
                        'parent_id' => $parent_id,
                    ]);

                } else {

                    $this->repository->insertChild([
                        'position' => $position,
                        'category_id' => $category_id,
                        'name' => $child['name'],
                        'parent_id' => $parent_id,
                    ]);
                }

                $position++;
            }
        }
    }

    private function isImportant(array $value): bool
    {
        return array_key_exists('important', $value)
            && (
                $value['important'] === 'true'
                || $value['important'] == 1
            );
    }
}
