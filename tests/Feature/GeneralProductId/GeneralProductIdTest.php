<?php

namespace Tests\Feature\GeneralProductId;

use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;
use Modules\Users\Models\User;
use Tests\TestCase;

class GeneralProductIdTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin=getAdminForTest();
    }

    public function test_create_generalId(): void
    {
        $categoryRepo=app(CategoryRepositoryInterface::class);
        $category=$categoryRepo->latest('id');
        $data=[
            'title'=>fake()->text(10),
            'category_id'=>$category->id,
            'general_id'=>rand(99999,999999)
        ];
        $response = $this
            ->actingAs($this->admin)
            ->post('/api/admin/general-product-ids',$data);
        $response->assertStatus(200);
    }

    public function test_show():void{
        $generalId=app(GeneralProductIdRepositoryInterface::class)->latest();
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/general-product-ids/'.$generalId->id);
        $this->assertEquals($response->json()['id'],$generalId->id);
        $response->assertStatus(200);
    }

    public function test_update():void{
        $generalId=app(GeneralProductIdRepositoryInterface::class)->latest();
        $title=fake()->text(10);
        $response = $this
            ->actingAs($this->admin)
            ->put('api/admin/general-product-ids/'.$generalId->id,[
                'title'       =>$title,
                'category_id' => $generalId->category_id,
                'general_id'  =>  $generalId->general_id
            ]);
        $response->assertStatus(200);
        $this->assertTrue(
            app(GeneralProductIdRepositoryInterface::class)->exists([
                'id'=>$generalId->id,
                'title'=>$title
            ])
        );
    }

    public function test_index():void{
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/general-product-ids');
        $body=$response->json();
        $this->assertArrayHasKey('data',$body);
        $this->assertGreaterThan(0,sizeof($body['data']));
        $response->assertStatus(200);
    }
}
