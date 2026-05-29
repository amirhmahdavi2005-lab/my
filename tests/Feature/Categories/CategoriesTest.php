<?php

namespace Tests\Feature\Categories;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
class CategoriesTest extends TestCase
{


    public function test_create()
    {
        $categoryRepository=app(CategoryRepositoryInterface::class);
        $keywordsRepository=app(CategoryKeywordRepositoryInterface::class);
        $data = Category::factory()->make()->toArray();
        $data['keywords'] = 'tag1,tag2';
        $response = $this->post( 'api/admin/categories', $data);
        $response->assertStatus(200);
        $this->assertEquals('ok', $response->json()['status']);
        $latest=$categoryRepository->latest('id');
        $tags=$keywordsRepository->arrayList($latest->id);
        $this->assertCount(2,$tags);

    }
    public function test_index()
    {
    $response = $this->get( 'api/admin/categories' );
    $body=$response->json();
    $this->assertArrayHasKey('data',$body);
    $this->assertGreaterThan(0,$response->json()['data']);
    $response->assertStatus(200);
    }

    public function test_index_search():void{

        Category::factory()->create(['name'=>'kalamotor' , 'deleted_at'=>now(),'slug'=>'kalamotor']);
        $response = $this->get( 'api/admin/categories?trashed=true&name=kalamotor');
        $this->assertArrayHasKey('data',$response->json());
        $count=app(CategoryRepositoryInterface::class)->countTrashedCategoriesByText('kalamotor');
        $this->assertEquals($response->json()['total'],$count);
        $response->assertStatus(200);
    }
    public function test_upload_image_for_create():void{
        $categoryRepository=app(CategoryRepositoryInterface::class);
        $data = Category::factory()->make()->toArray();
        $data ['pic']=UploadedFile::fake()->image('pic.png');
        $response = $this->post( 'api/admin/categories', $data);
        $latest=$categoryRepository->latest('id');
        $this->assertNotNull($latest->image);
        $response->assertStatus(200);
    }
    public function test_validate_for_create(): void{
        $data=Category::factory()->make()->toArray();
        unset($data['name']);
        $response = $this
            ->post('api/admin/categories',$data);
        $response->assertStatus(302);
    }
    public function test_show():void{
        $category=Category::factory()->create(['slug'=>'slug']);
        $response = $this->get('api/admin/categories/'.$category->id);
        $this->assertequals( $response->json()['id'],$category->id);
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $name=Str::random(5);
        $ename=Str::random(5);

        $category=Category::factory()->create(['slug'=>'slug']);
        $response = $this

            ->put('api/admin/categories/'.$category->id,[
                'name'=>$name,
                'ename'=>$ename
            ]);

        $this->assertDatabaseHas('categories',[
            'id'=>$category->id,
            'name'=>$name,
            'ename'=>$ename
        ]);

        $response->assertStatus(200);
    }

    public function test_destroy():void{
        $category=Category::factory()->create(['slug'=>'slug']);
        $response = $this->delete('api/admin/categories/'.$category->id);
        $this->assertDatabaseMissing('categories',['id'=>$category->id,'deleted_at'=>null]);
        $response->assertStatus(200);

    }
    public function test_restore():void{
        $category=Category::factory()->create(['slug'=>'slug','deleted_at'=> Carbon::now()]);
        $response = $this->post('api/admin/categories/'.$category->id.'/restore');
        $this->assertDatabaseHas('categories',['id'=>$category->id,'deleted_at'=>null]);
        $response->assertStatus(200);

    }
}

