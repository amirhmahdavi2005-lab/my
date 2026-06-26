<?php

namespace Tests\Feature\Categories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;
use Modules\Users\Models\User;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_create()
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $keywordsRepository = app(CategoryKeywordRepositoryInterface::class);

        $data = Category::factory()->make()->toArray();
        $data['keywords'] = 'tag1,tag2';

        $response = $this->actingAs($this->admin)
            ->post('api/admin/categories', $data);

        $response->assertStatus(200);
        $this->assertEquals('ok', $response->json()['status']);

        $latest = $categoryRepository->latest('id');
        $tags = $keywordsRepository->arrayList($latest->id);

        $this->assertCount(2, $tags);
    }

    public function test_upload_image_for_create(): void
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);

        $data = Category::factory()->make()->toArray();
        $data['pic'] = UploadedFile::fake()->image('pic.png');

        $response = $this->actingAs($this->admin)
            ->post('api/admin/categories', $data);

        $latest = $categoryRepository->latest('id');

        $this->assertNotNull($latest->image);
        $response->assertStatus(200);
    }

    public function test_validate_for_create(): void
    {
        $data = Category::factory()->make()->toArray();
        unset($data['name']);

        $response = $this->actingAs($this->admin)
            ->post('api/admin/categories', $data);

        $response->assertStatus(302);
    }

    public function test_index()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get('api/admin/categories');

        $body = $response->json();

        $this->assertArrayHasKey('data', $body);
        $this->assertGreaterThan(0, count($body['data']));

        $response->assertStatus(200);
    }

    public function test_index_search(): void
    {
        Category::factory()->create([
            'name' => 'idehpardazanjavn',
            'deleted_at' => now(),
            'slug' => 'idehpardazanjavn'
        ]);

        $response = $this->actingAs($this->admin)
            ->get('api/admin/categories?trashed=true&name=idehpardazan');

        $this->assertArrayHasKey('data', $response->json());

        $count = app(CategoryRepositoryInterface::class)
            ->countTrashedCategoriesByText('idehpardazan');

        $this->assertEquals($response->json()['total'], $count);

        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get('api/admin/categories/' . $category->id);

        $this->assertEquals($response->json()['id'], $category->id);

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $category = Category::factory()->create();

        $name = Str::random(5);
        $ename = Str::random(5);

        $response = $this->actingAs($this->admin)
            ->put('api/admin/categories/' . $category->id, [
                'name' => $name,
                'ename' => $ename
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $name,
            'ename' => $ename
        ]);

        $response->assertStatus(200);
    }

    public function test_destroy(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete('api/admin/categories/' . $category->id);

        $this->assertSoftDeleted('categories', [
            'id' => $category->id
        ]);

        $response->assertStatus(200);
    }

    public function test_restore(): void
    {
        $category = Category::factory()->create([
            'deleted_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->post('api/admin/categories/' . $category->id . '/restore');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'deleted_at' => null
        ]);

        $response->assertStatus(200);
    }

    public function test_all()
    {
        Category::factory()->count(3)->create();

        $response = $this->get('api/category/all');

        $categories = app(CategoryRepositoryInterface::class)->all();

        $this->assertEquals(count($categories), count($response->json()));
        $this->assertGreaterThan(0, count($categories));

        $response->assertStatus(200);
    }

    public function test_get_childs_categories()
    {
        $parent=Category::factory()->create(['slug'=>'slug']);
        $child1=Category::factory()->create(['parent_id'=>$parent->id,'slug'=>'slug']);
        $child2=Category::factory()->create(['parent_id'=>$child1->id,'slug'=>'slug']);
        $child3=Category::factory()->create(['parent_id'=>$child2->id,'slug'=>'slug']);
        $this->assertEquals(4 ,sizeof(getChildCategoriesId($parent->id)));
    }
}
