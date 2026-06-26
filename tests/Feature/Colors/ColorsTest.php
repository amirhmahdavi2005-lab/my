<?php

namespace Colors;

use Carbon\Carbon;
use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\Models\Color;
use Modules\Users\Models\User;
use Tests\TestCase;

class ColorsTest extends TestCase
{
    protected User|null $admin=null;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin=getAdminForTest();
    }

    public function test_create_color(): void
    {

        $data = Color::factory()->make()->toArray();
        $response = $this
            ->actingAs($this->admin)
            ->post('api/admin/colors', $data);
        $response->assertStatus(200);
    }
    public function test_show():void{
        $color=Color::factory()->create();
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/colors/'.$color->id);
        $this->assertEquals($response->json()['id'],$color->id);
        $response->assertStatus(200);
    }


    public function test_update():void{
        $color=Color::factory()->create();
        $name=fake()->colorName();
        $hex=fake()->hexColor();
        $response = $this
            ->actingAs($this->admin)
            ->put('api/admin/colors/'.$color->id,[
                'name'=>$name,
                'code'=>$hex
            ]);
        $this->assertTrue(
            app(ColorRepositoryInterface::class)->exists([
                'id'=>$color->id,
                'name'=>$name,
                'code'=>$hex
            ])
        );
        $response->assertStatus(200);
    }
    public function test_index(): void
    {
        $color=Color::factory()->create();
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/colors');
        $body = $response->json();
        $this->assertArrayHasKey('data', $body);
        $this->assertGreaterThan(0, sizeof($body['data']));
        $response->assertStatus(200);
    }
    public function test_index_search():void{
        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/colors?trashed=true&name=red');
        $body=$response->json();
        $this->assertArrayHasKey('data',$body);
        $count=app(ColorRepositoryInterface::class)
            ->countForTesting('red');
        $this->assertEquals($body['total'],$count);
        $response->assertStatus(200);
    }
    public function test_destroy():void{
        $color=Color::factory()->create();
        $response = $this
            ->actingAs($this->admin)
            ->delete('api/admin/colors/'.$color->id);
        $this->assertFalse(
            app(ColorRepositoryInterface::class)->exists([
                'id'=>$color->id,
                'deleted_at'=>null
            ])
        );
        $response->assertStatus(200);
    }
    public function test_restore():void{
        $color=Color::factory()->create(['deleted_at'=>Carbon::now()]);
        $response = $this
            ->actingAs($this->admin)
            ->post('api/admin/colors/'.$color->id.'/restore');
        $this->assertTrue(
            app(ColorRepositoryInterface::class)->exists([
                'id'=>$color->id,
                'deleted_at'=>null
            ])
        );
        $response->assertStatus(200);
    }

    public function test_get_all_colors()
    {
        $color=Color::factory()->create();
        $response = $this
            ->get('api/colors/list');
        $this->assertGreaterThan(0,sizeof($response->json()));
        $response->assertStatus(200);

    }

}
