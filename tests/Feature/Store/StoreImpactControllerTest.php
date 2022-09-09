<?php

namespace Tests\Feature\Store;

use App\Models\Quality;
use App\Models\Store;
use Database\Seeders\QualitySeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreImpactControllerTest extends TestCase
{
    public function test_an_authenticated_admin_cannot_qualify_impact_score_without_params()
    {
        $this->seed(QualitySeeder::class);
        $store = Store::factory()->create();
        $this->createAuthenticatedAdmin();

        $data = [];
        $response = $this->postJson(route('store.impact', $store->id), $data);

        $response->assertUnprocessable();
    }

    public function test_an_authenticated_admin_can_qualify_impact_score_with_3_quality_params()
    {
        $this->seed(QualitySeeder::class);
        $store = Store::factory()->create();
        $this->createAuthenticatedAdmin();

        $data = [
            'qualities' => Quality::query()->inRandomOrder()->limit(3)->get()->pluck('id')->toArray(),
        ];
        $response = $this->postJson(route('store.impact', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'qualities' => [
                    0 => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
        $this->assertEquals(0, DB::table('qualityables')->where('is_impact', false)->count());
        $this->assertEquals(3, DB::table('qualityables')->where('is_impact', true)->count());
    }

    public function test_an_authenticated_admin_can_qualify_impact_score_with_3_quality_params_and_2_files()
    {
        Storage::fake('s3');
        $this->seed(QualitySeeder::class);
        $store = Store::factory()->create();
        $this->createAuthenticatedAdmin();

        $data = [
            'qualities' => Quality::query()->inRandomOrder()->limit(3)->get()->pluck('id')->toArray(),
            'files' => [
                [
                    'quality_id' => Quality::inRandomOrder()->first()->id,
                    'file' => UploadedFile::fake()->image('image.png'),
                ],
                [
                    'quality_id' => Quality::inRandomOrder()->first()->id,
                    'file' => UploadedFile::fake()->image('image.png'),
                ]
            ],
        ];
        $response = $this->postJson(route('store.impact', $store->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'qualities' => [
                    0 => [
                        'id',
                        'name',
                    ],
                ],
                'files' => [
                    0 => [
                        'id',
                        'quality_id',
                        'orientation',
                        'url',
                    ],
                ],
            ],
        ]);
        $this->assertEquals(0, DB::table('qualityables')->where('is_impact', false)->count());
        $this->assertEquals(3, DB::table('qualityables')->where('is_impact', true)->count());
        $this->assertDatabaseCount('media', 2);
    }
}
