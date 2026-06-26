<?php

namespace Modules\Galleries\Services;

use Modules\Galleries\Contracts\GalleryRepositoryInterface;
use Modules\Galleries\Contracts\GalleryServiceInterface;
use Modules\Galleries\Utils\WatermarkManager;

class SaveGalleryFileService implements GalleryServiceInterface
{
    public function __construct(
        protected GalleryRepositoryInterface $galleryRepository,
        protected   $watermarkManager
    ) {}

    public function handel(array $data, bool $withWatermark = false): void
    {
        $conditions = collect($data)
            ->except(['user_id', 'position', 'user_type'])
            ->toArray();

        $existing = $this->galleryRepository->findByConditions($conditions);

        if (!$existing) {
            $this->galleryRepository->create($data);

            if ($withWatermark && config('gallery.watermark') === 'true') {
                $this->watermarkManager->apply($data['path']);
            }
        }
    }
}
