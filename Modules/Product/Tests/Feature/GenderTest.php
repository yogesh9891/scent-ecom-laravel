<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Gender;

class GenderTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $this->post('/product/genders-store',[
            'name' => 'test category 99',
            'description' => 'gender description',
            'link' => '#',
            'meta_title' => 'test',
            'meta_description' => 1,
            'status' => 0,
            'logo' => UploadedFile::fake()->image('image.jpg', 56, 56),
            'featured' => 1
        ])->assertRedirect('/product/genders-list');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $gender = Gender::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/genders-update/'.$gender->id,[
            'name' => 'test category 99 edit',
            'description' => 'gender description',
            'link' => '#',
            'meta_title' => 'test',
            'meta_description' => 1,
            'status' => 0,
            'logo' => UploadedFile::fake()->image('image.jpg', 56, 56),
            'featured' => 1
        ])->assertRedirect('/product/genders-list');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_delete_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $gender = Gender::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->get('/product/genders-destroy/'.$gender->id)->assertRedirect('/product/genders-list');

    }

    public function test_for_status_change_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $gender = Gender::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/genders-update-status',[
            'id' => $gender->id,
            'status' => 1
        ])->assertSee(1);

    }

    public function test_for_featured_change_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $gender = Gender::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/genders-update-feature',[
            'id' => $gender->id,
            'status' => 1
        ])->assertSee(1);

    }

    public function test_for_load_more_gender()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/product/load-more-gender',[
            'skip' => 10
        ])->assertSee('genders');

    }

}
