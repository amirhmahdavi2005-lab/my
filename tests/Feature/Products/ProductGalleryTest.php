<?php

namespace Tests\Feature\Products;

use Modules\users\Models\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ProductGalleryTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin=getAdminForTest();
    }

    public function test_upload(){
        $response=$this->actingAs($this->admin)
            ->post('/api/admin/product/gallery',[
                'files'=>[
                    UploadedFile::fake()->image('image1.png'),
                    UploadedFile::fake()->image('image1.png')
                ]
            ]);
        $response->assertStatus(200);
        return $response->json()['paths'];
    }

    #[\PHPUnit\Framework\Attributes\Depends('test_upload')]
    public function test_destory($paths){
        $response=$this->actingAs($this->admin)->delete('/api/admin/product/gallery',[
            'path'=>$paths[0]
        ]);
        $response->assertStatus(200)
            ->assertJson(['status'=>'ok']);
    }
}
