<?php

namespace Tests\Feature\Store;

use App\Models\Quality;
use App\Models\Store;
use Database\Seeders\QualitySeeder;
use Illuminate\Support\Facades\DB;
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
        $this->assertEquals(0, DB::table('qualityables')->where('is_impact', false)->count());
        $this->assertEquals(3, DB::table('qualityables')->where('is_impact', true)->count());
    }
}
