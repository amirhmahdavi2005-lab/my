<?php

namespace Galleries;

use Illuminate\Http\UploadedFile;
use Modules\Users\Models\User;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_save_setting()
    {
        $response = $this->actingAs($this->admin)
            ->post('/api/admin/setting/gallery', [
                'image' => UploadedFile::fake()->image('icon.png', 100, 100),
                'watermark' => 'false',
                'position' => 'bottom-right',
                'position_x' => '15',
                'position_y' => '15',
            ]);
        $response->assertStatus(200);
    }

    public function test_config()
    {
        $response = $this->actingAs($this->admin)->get('api/admin/setting/gallery');
        $galleryConfig = config('gallery');
        $this->assertEquals($galleryConfig['image'],
            $response->json()['image']);
        $response->assertStatus(200);
    }


}
