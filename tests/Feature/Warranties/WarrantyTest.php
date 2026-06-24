<?php

namespace Tests\Feature\Warranties;

use Carbon\Carbon;
use Modules\Users\Models\User;
use Modules\Warranties\Contracts\WarrantyRepositoryInterface;
use Modules\Warranties\Models\Warranty;
use Tests\TestCase;

class WarrantyTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin=getAdminForTest();
    }

    public function test_create_warranty(): void
    {
        $warranty=Warranty::factory()->make();
        $response = $this
            ->actingAs($this->admin)
            ->post('api/admin/warranties',$warranty->toArray());
        $response->assertStatus(200);
    }

    public function test_show():void{
        $warranty=Warranty::factory()->create();
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/warranties/'.$warranty->id);
        $this->assertEquals($response->json()['id'],$warranty->id);
        $response->assertStatus(200);
    }

    public function test_update():void{
        $warranty=Warranty::factory()->create();
        $name=fake()->text(10);
        $link=fake()->url();
        $response = $this
            ->actingAs($this->admin)
            ->put('api/admin/warranties/'.$warranty->id,[
            'name'=>$name,
            'link'=>$link,
            'phone_number'=>$warranty->phone_number
        ]);
        $this->assertTrue(
            app(WarrantyRepositoryInterface::class)->exists([
                'id'=>$warranty->id,
                'name'=>$name,
                'link'=>$link
            ])
        );
        $response->assertStatus(200);
    }

    public function test_index():void{
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/warranties');
        $body=$response->json();
        $this->assertArrayHasKey('data',$body);
        $this->assertGreaterThan(0,sizeof($body));
        $response->assertStatus(200);
    }

    public function test_index_search():void{
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/warranties?trashed=true&name=red');
        $this->assertArrayHasKey('data',$response->json());
        $this->assertEquals($response->json()['total'],
            app(WarrantyRepositoryInterface::class)->countForTesting('test')
        );
        $response->assertStatus(200);
    }

    public function test_destroy():void{
        $warranty=Warranty::factory()->create();
        $response = $this
            ->actingAs($this->admin)
            ->delete('api/admin/warranties/'.$warranty->id);
        $this->assertFalse(
            app(WarrantyRepositoryInterface::class)->exists([
                'id'=>$warranty->id,
                'deleted_at'=>null
            ])
        );
        $response->assertStatus(200);
    }

    public function test_restore():void{
        $warranty=Warranty::factory()->create([
            'deleted_at'=>Carbon::now()
        ]);
        $response = $this
            ->actingAs($this->admin)
            ->post('api/admin/warranties/'.$warranty->id.'/restore');
        $this->assertTrue(
            app(WarrantyRepositoryInterface::class)->exists([
                'id'=>$warranty->id,
                'deleted_at'=>null
            ])
        );
        $response->assertStatus(200);
    }
}
